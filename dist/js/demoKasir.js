    // Object pada kasir untuk fitur pencarian
	function search_enggine( call_back, time ){
		var Interval = {
			jalankan:call_back,
			Times:null,
			getTimes:function(){
				Interval.Times = setTimeout(Interval.jalankan, time);
			},
			EksekusiInput:function(){
				clearTimeout(Interval.Times);
				Interval.getTimes();
			}
		};
		return Interval;
	}
	
    var objKasir = {
    	url:'',
    	pencarianTarget:false,
    	data:true,
    	cariData:function(url, search){
    		$.ajax({  
	          type: "POST",
	          url: url+'index.php/c_penjualan/cari_barang',
	          data:"pencarian="+search+"&jenis=cari",
	          success:function(response){
	            var kal = JSON.parse(response);
	            if(kal.query !== "No Data"){
	              $('.ket-pencarian #keterangan-pencarian').html( objKasir.getData(kal) );
	              objKasir.getKlik();
	              objKasir.data = kal;
	            }else{
	              $('.ket-pencarian #keterangan-pencarian').html( objKasir.HtmlVal("<div class='value-search'>","Tidak ada data seperti itu" ,"</div>") );
	            }
	          }
	      	}).fail(function(j, text){
	        	alert('sistem not respon !!');
	      	});
    	},
    	getData:function(e){
    		var arg = "";
		      for(var i=0; i<e.query.length; i++){
		        var ket = e.query[i];
		        arg+=objKasir.HtmlVal("<div class='value-search'>",ket.nama_barang,"</div>");
		      }
      		return arg;
    	},
    	HtmlVal:function(pembuka, value, penutup){
    		var html = pembuka+''+value+''+penutup;
      		return html;
    	},
    	pencarian:function(){
			var searchVal = search_enggine(function(){
				 var kal = $("#teks-pencarian").val(),
	              search = kal.replace(/^\s+/g,"");
				$('.ket-pencarian').show();
	             	objKasir.cariData( objKasir.url, search );
	                $('.ket-pencarian #kalimat').html("Mencari "+'<strong>"'+kal+'"</strong>');
	                objKasir.pencarianTarget = true;
			}, 300);
    		$("#teks-pencarian").keyup(function(e){
	            var kal = $("#teks-pencarian").val(),
	              search = kal.replace(/^\s+/g,"");
	              if((search.length > 0)&&((e.keyCode >= 48 && e.keyCode <= 57)||(e.keyCode >= 65 && e.keyCode <= 90)||(e.keyCode == 8)||(e.keyCode == 32))){
	                searchVal.EksekusiInput();
	              }else{
	                objKasir.Tblur();
	              }
      		});
    	},
    	getKlik:function(){
    		$('.ket-pencarian .value-search').click(function(e){
		        if(objKasir.pencarianTarget){
		          $("#teks-pencarian").val( $(this).html() );
		          objKasir.Tblur();
		          objKasir.pencarianTarget = false;
		        }
      		});
    	},
    	Tblur:function(){
    		$('.ket-pencarian #keterangan-pencarian').html('');
       		$('.ket-pencarian #kalimat').html('');
       		$('.ket-pencarian').hide();
    	},
    	aktivated:function(){
    		objKasir.pencarian();
    		$(document).click(function(e){
		        if(objKasir.pencarianTarget){
		          objKasir.Tblur();
		          objKasir.pencarianTarget = false;
		        }
		    });
    	}
    };

    // Object yang digunakan untuk menampilkan barang
    var tampilBarang = {
    	data:'',
    	klikPencarian:function(){
    		$('.tmbl-pencarian').click(function(){
    			var kal = $("#teks-pencarian").val(),
	              search = kal.replace(/^\s+/g,"");
    			$.ajax({  
		          type: "POST",
		          url: objKasir.url+'index.php/c_penjualan/cari_barang',
		          data:"pencarian="+search+"&jenis=dapat",
		          success:function(response){
		            tampilBarang.data = JSON.parse(response);
                    if(tampilBarang.data.query != 'No Data'){
                        tampilBarang.getData();
                    }else{
                        alert('Barang '+search+' tidak ada');
                    }
		          }
		      	}).fail(function(j, text){
		        	alert('sistem not respon !!');
		      	});
    		});
    	},
    	getData:function(){
    		var string = "<table class='table table-bordered'><tbody><tr><th style='width: 10px'>#</th><th style='width:35%'>Nama Barang</th><th>Satuan</th><th>Harga</th><th>Stok</th><th>Penempatan</th><th style='width: 12%'>Operasi</th></tr>";
    		if(tampilBarang.data.query){
    			if(tampilBarang.data.query.length > 0){
    				for(var i=0; i<tampilBarang.data.query.length; i++){
    					var j = i+1;
    					string+='<tr>';
    					string+=objKasir.HtmlVal('<td>',j, '</td>');
    					string+=objKasir.HtmlVal('<td>', tampilBarang.data.query[i].nama_barang, '</td>');
						string+=objKasir.HtmlVal('<td>', tampilBarang.data.query[i].satuan, '</td>');
    					string+=objKasir.HtmlVal('<td>', tampilBarang.data.query[i].harga_jual, '</td>');
    					string+=objKasir.HtmlVal('<td>', tampilBarang.data.query[i].jumlah_stok, '</td>');
						string+=objKasir.HtmlVal('<td>', tampilBarang.data.query[i].nama_penempatan, '</td>');
    					string+=objKasir.HtmlVal('<td>', "<button type='button' class='btn btn-primary btn-sm ambil-barang' alt='"+i+"' data-target='#modal-default-barang' data-toggle='modal' style='float:left; width:100%;'>Ambil</button>", '</td>');
    					string+='</tr>';
    				}
    			}
    		}
    		string+="</tbody></table>";
    		$('.tabel-barang').html( string );
    		tampilBarang.klikOperasi();
    		$('.konten-barang').fadeOut().fadeIn();
    	},
    	klikOperasi:function(){
    		$('.ambil-barang').click(function(){
    			var index = parseInt($(this).attr('alt'));
    			index = tampilBarang.data.query[index];
    			$('#modal-default-barang .modal-nama-barang').html( index.nama_barang );
    			$('#modal-default-barang .modal-idbarang').html(index.id_barang);
    			$('#modal-default-barang .modal-harga').html( index.harga_jual );
    			$('#modal-default-barang .modal-stok').html( index.jumlah_stok );
    			$('#modal-default-barang .modal-nama-satuan').html( index.satuan );
    			$('#modal-default-barang .modal-jumlah').html( "<input type='number' min='1' max='"+index.jumlah_stok+"' name='angka' value='1'/>" );
    		});
    	},
    	get:function(){
    		tampilBarang.klikPencarian();
    	}
    };

    var hitungBarang = {
    	getSukses:false,
    	TotalHarga:0,
    	tagBarang:function(id_barang, nama_barang, jumlah, satuan, harga, stok_berkurang){
    		var i = "<tr>";
    		  i+=objKasir.HtmlVal('<td>', '<input class="form-control input-sm" id="NMidbarang" type="text" name="id_barang[]" readonly="true" value="'+id_barang+'" />', '</td>');
		      i+=objKasir.HtmlVal('<td>', '<input class="form-control input-sm" id="NMbarang" type="text" name="barang[]" readonly="true" value="'+nama_barang+'" />', '</td>');
			  i+=objKasir.HtmlVal('<td>', '<input class="form-control input-sm" id="NMsatuan" type="text" name="satuan[]" readonly="true" value="'+satuan+'" />', '</td>');
		      i+=objKasir.HtmlVal('<td>', '<input class="form-control input-sm" id="NMjumlah" type="text" name="jumlah[]" readonly="true" value="'+jumlah+'" /> <input type="hidden" name="stok_kurang[]" value="'+stok_berkurang+'">', '</td>');
		      i+=objKasir.HtmlVal('<td>', '<input class="form-control input-sm" id="NMharga" type="text" name="harga[]" readonly="true" value="'+harga+'" />', '</td>');
		      i+=objKasir.HtmlVal('<td>', '<button type="button" alt="'+harga+'" class="btn btn-block btn-danger btn-sm hapus-barang" onClick="get_hapus_barang(this, event)" >Hapus</button>', '</td>');
		      i+="</tr>";
		      return i;
    	},
    	klikTambahkan:function(){
    		$('.tambah-barang').click(function(){
    			var id_barang = $('#modal-default-barang .modal-idbarang').html(),
    			nama_barang = $('#modal-default-barang .modal-nama-barang').html(),
    			stok = $('#modal-default-barang .modal-stok').html(),
    			jumlah = parseInt($('#modal-default-barang .modal-jumlah input[type=number]').val()),
    			satuan = $('#modal-default-barang .modal-nama-satuan').html();
    			harga = parseInt($('#modal-default-barang .modal-harga').html());
    			harga = harga*jumlah;
    			stok_berkurang = parseInt(stok) - jumlah;
    			$('.tabel-himpunan-barang tbody').append( hitungBarang.tagBarang( id_barang, nama_barang, jumlah, satuan, harga, stok_berkurang ) );
    			hitungBarang.TotalHarga+=harga;
    			hitungBarang.tampilTotalharga();
    			$('.konten-barang-beli').show();
    		});
    	},
    	tampilTotalharga:function(){
    		$('.jumlah-pembayaran #jumlah .info-box-number').html( hitungBarang.TotalHarga );
    	},
    	beliAktif:function(){
			// fungsi javascript yang digunakan untuk pembayaran
			// setelah enginput data - data barang
			// fungsi inilah yang bertanggung jawab terhadap penyimpanan data
			// di database
    		$('.bayar').click(function(){
				var pembayaran = parseInt($('.jumlah-pembayaran #jumlah span').html());
				var bayar = parseInt($('input[name=bayar]').val());
				var dataForm = $('form#form-beli').serialize();
				if(bayar >= pembayaran){
					$.ajax({
						url:objKasir.url+'index.php/c_penjualan/simpan_penjualan',
						type:"POST",
						data:dataForm,
						beforeSend:function(){

						},
						success:function(result){
							var data = JSON.parse(result);
							$('.tabel-hasil-perhitungan tbody').html(data.tag);
							$('.konten-display-penjualan #customer').val(data.customer);
							$('.konten-barang-beli #customer').val('');
							$('.col-konten-utama').hide();
							$('.konten-display-penjualan').fadeOut().fadeIn();
							if(data.status == 'success'){
								hitungBarang.getSukses = true;
								$('input[name=bayar]').val('');
							}
						},
						error:function(xhr, status, err){
							alert('terjadi kesalahan '+err);
						}
					});
				}else{
					$('.konten-peringatan-pembayaran').show();
				}
    			
    		});

    	},
    	klikKembali:function(){
    		$('.btn-kembali').click(function(){
    			if(hitungBarang.getSukses){
    				hitungBarang.TotalHarga = 0;
    				SuksesUpdate();
    			} else {
    				$('.konten-display-penjualan').hide();
    				$('.col-konten-utama').fadeIn();
    			} 			
    		});
    	},
    	getBarang:function(){
    		hitungBarang.klikTambahkan();
    		hitungBarang.beliAktif();
    		hitungBarang.klikKembali();
    	}
   
    }

    function get_hapus_barang(t, e){
    	e.preventDefault();
    	var tr = $(t).parent().parent(),
    	harga_barang = $(t).attr('alt');
    		hitungBarang.TotalHarga-=parseInt(harga_barang);
    		hitungBarang.tampilTotalharga();
    		tr.remove();
    	if( hitungBarang.TotalHarga < 1){
    		$('.konten-barang-beli').hide();
    		hitungBarang.TotalHarga = 0;
    	}
    }

    function SuksesUpdate(){
		/* 
		Fungsi javascript yang digunakan ketika semua proses pembayaran
		telah selesai dan telah diklik tombol kembali
		*/
    	$('.konten-display-penjualan').hide();
    	$('.konten-barang').hide();
    	$('.konten-barang-beli').hide();
    	$('.tabel-himpunan-barang tbody').html('');
    	$('.col-konten-utama').show();
		$('.konten-peringatan-pembayaran').hide();
    }
	
	  objKasir.url = Datadefine['url'];
	objKasir.aktivated();
	tampilBarang.get();
	hitungBarang.getBarang();
	$('.hilang').click(function(){
		$('.konten-barang').fadeOut();
	});
	$('#tbl-tutup-pembayaran').click(function(){
		$('.konten-peringatan-pembayaran').hide();
	});
