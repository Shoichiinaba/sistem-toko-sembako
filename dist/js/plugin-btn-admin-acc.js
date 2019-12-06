var dataDokumen = function(){
	let data = [];
	var t_dokument = $(document);
	this.addData = function(string, object){
		if(!data[string]){
			data[string] = object;
		}
	}
	this.eksekusi = function(){
		t_dokument.click(function(e){
			if(e.target.dataset.cstarget){
				data[e.target.dataset.cstarget].result(e);
			}
		});
	}
	this.showData = function(){
		console.log(data);
	}
}

var observer = new dataDokumen();
observer.eksekusi();

function ajaxRequest(callback){
	$.ajax(callback).fail(function(j, teks){
		alert('Server tak bisa diakses');
	});
}
$('#loader').hide();
(function(dot){
	var pageMore = function(){
		var pageLength = 2,
		getHal = () => (Datadefine['index-hal'] * pageLength) - pageLength,
		getUpdateHal = function(e)
		{
			if(Datadefine['index-hal'] >= Datadefine['maksimal-hal'])
				$(e).hide();
		},
		updateKetdata = function(){
			var jumlah = $('.tampil-barang tbody tr').length;
			$('#ket-index-data')
			.html('<p>Menampilkan <strong>'+jumlah+'</strong> dari <strong>'+Datadefine['count-data']+'</strong> data. </p>');
		}
		return {
			result:function(){
				var btn = arguments[0].target;
				Datadefine['index-hal']++;
				if(Datadefine['tipe-konten'] == 'belum'){
					var url = Datadefine['url']+"index.php/c_function/panggil_data_barang_beli_acc/belum";
				}else{
					var url = Datadefine['url']+"index.php/c_function/panggil_data_barang_beli_acc/sudah";
				}
				ajaxRequest({
					type: "get",
	          		url: url,
	          		data:"index="+getHal()+"&length="+pageLength+"&tanggal="+Datadefine['tanggal'],
	          		beforeSend:function(){
	          			btn.disabled = true;
						btn.innerHTML = 'Loading...';
	          		},
	          		success:function( result ){
	          			var data = JSON.parse(result);
	          			$('.tampil-barang tbody').append( data.data );
	          			btn.disabled = false;
	          			btn.innerHTML = 'Tampilkan Lagi';
	          			getUpdateHal(btn);
	          			updateKetdata();
	          		}
				});
			}
		}
	}
	var pageMore_ = new pageMore();
  	dot.addData('pageMore', pageMore_);
})( observer );

(function(dot){
	var searchNpage = function(){
		var updateIndexData = function(){
			var jumlah = $('.tampil-barang tbody tr').length;
			$('#ket-index-data')
			.html('<p>Menampilkan <strong>'+jumlah+'</strong> dari <strong>'+Datadefine['count-data']+'</strong> data. </p>');
		},
		updatePageMoreBtn = function(){
			$('#page-more').html('<button type="button" class="btn btn-default btn-block btn-more" data-cstarget="pageMoresearch">Tampilkan Lagi</button>');
		};
		return {
			result:function(){
				if(Datadefine['tipe-konten'] == 'belum'){
					var url = Datadefine['url']+"index.php/c_function/pencarian_data_pembelian_acc/belum";
				}else{
					var url = Datadefine['url']+"index.php/c_function/pencarian_data_pembelian_acc/sudah";
				}
				var atribut = $('.fil-atr').val(),
					cari = $('.fil-cari').val();
				ajaxRequest({
					type:'get',
					url:url,
					data:'atribut='+atribut+'&cari='+cari,
					beforeSend:function(){
						
					},success:function(result){
						var r = JSON.parse(result);
						Datadefine['maksimal-hal'] = parseInt(r.maxHal);
						Datadefine['index-hal'] = 1;
						Datadefine['count-data'] = r.countData;
						$('#page-more').html('');
						if(r.countData >= 1){
							$('table.tampil-barang tbody').html(r.data);
							if(r.next == "ada"){
								updatePageMoreBtn();
							}
						}else{
							$('table.tampil-barang tbody').html('<p>No data</p>');
						}
						updateIndexData();
						Datadefine['atribut'] = atribut;
						Datadefine['cari'] = cari;
					}
				});
			}
		}
	}
	var searchNpage_ = new searchNpage();
  	dot.addData('searchNpage', searchNpage_);
})( observer );

(function(dot){
	var pageMoresearch = function(){
		var pageLength = 2,
		getHal = () => (Datadefine['index-hal'] * pageLength) - pageLength,
		getUpdateHal = function(e)
		{
			if(Datadefine['index-hal'] >= Datadefine['maksimal-hal'])
				$(e).hide();
		},
		updateKetdata = function(){
			var jumlah = $('.tampil-barang tbody tr').length;
			$('#ket-index-data')
			.html('<p>Menampilkan <strong>'+jumlah+'</strong> dari <strong>'+Datadefine['count-data']+'</strong> data. </p>');
		}
		return {
			result:function(){
				if(Datadefine['tipe-konten'] == 'belum'){
					var url = Datadefine['url']+"index.php/c_function/pencarian_data_pembelian_acc_next/belum";
				}else{
					var url = Datadefine['url']+"index.php/c_function/pencarian_data_pembelian_acc_next/sudah";
				}
				let btn = arguments[0].target;
				let atribut = Datadefine['atribut'];
				let cari = Datadefine['cari'];
				Datadefine['index-hal']++;
				ajaxRequest({
					type: "get",
	          		url: url,
	          		data:"atribut="+atribut+"&cari="+cari+"&index="+getHal()+"&length="+pageLength,
	          		beforeSend:function(){
	          			btn.disabled = true;
						btn.innerHTML = 'Loading...';
	          		},
	          		success:function( result ){
	          			var data = JSON.parse(result);
	          			$('.tampil-barang tbody').append( data.data );
	          			btn.disabled = false;
	          			btn.innerHTML = 'Tampilkan Lagi';
	          			getUpdateHal(btn);
	          			updateKetdata();
	          		}
				});
			}
		}
	}
	var pageMoresearch_ = new pageMoresearch();
	dot.addData('pageMoresearch', pageMoresearch_);
})( observer );

(function(dot){
	var delPick = function(){
		return {
			result:function(){
				let id = arguments[0].target.parentNode.parentNode.children[0].innerHTML;
				let nama = arguments[0].target.parentNode.parentNode.children[1].innerHTML;
				let tanggal = arguments[0].target.parentNode.parentNode.children[5].innerHTML;
				if(typeof objectDel_ === "undefined"){
					objectDel_ = arguments[0].target.parentNode.parentNode;
				}else{
					delete objectDel_;
					objectDel_ = arguments[0].target.parentNode.parentNode;
				}
				$('.modal-danger .modal-body input[name=id_barang]').val(id);
				$('.modal-danger .modal-body input[name=tanggal]').val(tanggal);
				$('.modal-danger .modal-body span').html(nama);
			}
		}
	}
	var delPick_ = new delPick();
	dot.addData('delPick', delPick_);
})(observer);

(function(dot){
	var addStock = function(){
		return {
			result:function(){
				let id = arguments[0].target.parentNode.parentNode.children[0].innerHTML;
				let url = Datadefine['url']+"index.php/c_function/get_data_barang_jual";
				let btn = arguments[0].target;
				ajaxRequest({
					type: "get",
	          		url: url,
	          		data:"id="+id,
	          		beforeSend:function(){
						btn.disabled = true;
						btn.innerHTML = "&nbsp;Loading...";
						$('.panel-tambahkan .box-body table tbody').empty();
						if(typeof btnAction_ === "undefined"){
							btnAction_ = btn;
						}else{
							delete btnAction_;
							btnAction_ = btn;
						}
	          		},
	          		success:function( result ){
	          			var data = JSON.parse(result);
						
						if(data.data != 'failed'){
							$.each(data.data, function(index, val){
								var tr = $('<tr></tr>');
								let id_barang = '<td><input type="text" class="form-control" name="id_barang[]" value="'+val.id_barang+'" readonly></td>',
								nama_barang = '<td><input type="text" class="form-control" name="nama_barang[]" value="'+val.nama_barang+'" readonly></td>',
								stok = '<td><input type="text" class="form-control"  name="stok[]" value="'+val.stok+'" readonly></td>',
								ditambahkan = '<td><input type="number" class="form-control" name="tambahkan[]" min="0" max="100"></td>',
								stok_maksimum = '<td><input type="text" class="form-control" name="stok_maksimum[]" value="'+val.stok_maksimum+'" readonly></td>';
								var html = id_barang+nama_barang+stok+ditambahkan+stok_maksimum;
								tr.append(html);
								$('.panel-tambahkan .box-body .table tbody').append(tr);
							});
							$('.panel-tambahkan .box').slideDown('slow');
						} else {
							btn.disabled = false;
							btn.innerHTML = "&nbsp;Tambahkan";
						}
	          		}
				});
			}
		}
	}
	var addStock_ = new addStock();
	dot.addData('addStock', addStock_);
})(observer);

$('#delete').click(function(e){
	if(Datadefine['tipe-konten'] == 'belum'){
		var url = Datadefine['url']+"index.php/c_function/hapus_barang_beli_acc/belum";
	}else{
		var url = Datadefine['url']+"index.php/c_function/hapus_barang_beli_acc/sudah";
	}
	ajaxRequest({
		type:'get',
		url:url,
		data:$('#form-hapus-barang').serialize(),
		beforeSend:function(){
			$('.modal-danger .loader').html('<i>Sedang proses menghapus...</i>');
		},
		success:function(result){
			var data = JSON.parse(result);
			if(data.result === "sukses"){
				$('.modal-danger .loader > i').remove();
				$('.modal-danger #tutup').click();
				if(typeof objectDel_ !== "undefined"){
					objectDel_.remove();
					delete objectDel_;

				}
			}
		}
	})
});
$('#refresh-barang').click(function(e){
	var updateIndexData = function(){
		var jumlah = $('.tampil-barang tbody tr').length;
			$('#ket-index-data')
			.html('<p>Menampilkan <strong>'+jumlah+'</strong> dari <strong>'+Datadefine['count-data']+'</strong> data. </p>');
	},
	updatePageMoreBtn = function(){
		$('#page-more').html('<button type="button" class="btn btn-default btn-block btn-more" data-cstarget="pageMore">Tampilkan Lagi</button>');
	}
	if(Datadefine['tipe-konten'] == 'belum'){
		var url = Datadefine['url']+"index.php/c_function/refresh_barang_beli_acc/belum";
	}else{
		var url = Datadefine['url']+"index.php/c_function/refresh_barang_beli_acc/sudah";
	}
	ajaxRequest({
		type:'get',
		url:url,
		data:'',
		beforeSend:function(){
			$('#refresh-box').show();
		},success:function(result){
			var r = JSON.parse(result);
				Datadefine['maksimal-hal'] = parseInt(r.maxHal);
				Datadefine['index-hal'] = 1;
				Datadefine['count-data'] = r.countData;
				$('#page-more').html('');
				if(r.countData > 0){
					$('table.tampil-barang tbody').html(r.data);
					$('#ket-pencarian').html('');
					updateIndexData();
					if(r.next == "ada"){
						updatePageMoreBtn();
					}
				}else{
					$('table.tampil-barang tbody').html('');
					$('#ket-index-data').html('');
				}
			$('#refresh-box').hide();
		}
	});
});
if(Datadefine['tipe-konten'] == 'sudah'){
	$('.panel-tambahkan .box .hilang').click(function(e){
		e.preventDefault();
		$('.panel-tambahkan .box').slideUp('slow', function(){
			if(btnAction_){
				btnAction_.disabled = false,
				btnAction_.innerHTML = "&nbsp;Tambahkan";
			}
		});
	});
	$('#batal-tambah-stok').click(function(e){
		e.preventDefault();
		$('.panel-tambahkan .box').slideUp('slow', function(){
			if(btnAction_){
				btnAction_.disabled = false,
				btnAction_.innerHTML = "&nbsp;Tambahkan";
			}
		});
	});
	$('#kirim-tambah-stok').click(function(e){
		e.preventDefault();
		var data = $('#form-tambah-stok').serialize();
		ajaxRequest({
			url:Datadefine['url']+'index.php/c_function/tambah_stok_barang',
			type:'GET',
			data:data,
			beforeSend:function(){
				$('#loader').show();
			},
			success:function(result){
				var hasil = JSON.parse(result);
				if(hasil.result == "success"){
				  ajaxRequest({
					 url:Datadefine['url']+'index.php/c_function/ubah_status_barang_beli',
					 type:'GET',
					 data:'id='+btnAction_.attributes.alt.value,
					 success:function(result){
						 if(JSON.parse(result).status == 'success'){
							btnAction_.disabled = false,
							 btnAction_.innerHTML = "&nbsp;Ditambahkan";
							 btnAction_.classList.remove('btn-primary');
							 btnAction_.classList.add('btn-success');
							 btnAction_.classList.remove('fa-plus');
							 btnAction_.classList.add('fa-check');
							 btnAction_.attributes.removeNamedItem('data-cstarget');
							 $('.panel-tambahkan .box').slideUp('slow');
						 }else{
							btnAction_.disabled = false,
							btnAction_.innerHTML = "&nbsp;Tambahkan";
						 }
					 }
				  });
				}else{
					alert('Sistem tidak dapat menambah data stok');
					btnAction_.disabled = false,
					btnAction_.innerHTML = "&nbsp;Tambahkan";
					$('#loader').hide();
				}
				$('#loader').hide();
			}
		});
	});
}