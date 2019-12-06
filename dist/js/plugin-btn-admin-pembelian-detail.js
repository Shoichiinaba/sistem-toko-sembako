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
				var url = Datadefine['url']+"index.php/c_pembelian/panggil_data_daftar_pembelian_detail_lanjut";
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
	var delPick = function(){
		return {
			result:function(){
				let id = arguments[0].target.parentNode.parentNode.children[0].innerHTML;
				let nama = arguments[0].target.parentNode.parentNode.children[1].innerHTML
				if(typeof objectDel_ === "undefined"){
					objectDel_ = arguments[0].target.parentNode.parentNode;
				}else{
					delete objectDel_;
					objectDel_ = arguments[0].target.parentNode.parentNode;
				}
				$('.modal-danger .modal-body input').val(id);
				$('.modal-danger .modal-body span').html(nama);
			}
		}
	}
	var delPick_ = new delPick();
	dot.addData('delPick', delPick_);
})(observer);

(function(dot){
	var editReck = function(){
		return {
			result:function(){
				var element = arguments[0],
  				id = element.target.parentNode.parentNode.children[0].innerHTML,
  				url = Datadefine['url']+"index.php/c_pembelian/tampil_edit_pembelian";
  				ajaxRequest({
  					type:'get',
  					url:url,
  					data:'id='+id,
  					beforeSend:function(){
  						$('.modal-warning #form-edit-pembelian').html('<p>Loading...</p>');
  					},
  					success:function(result){
  						$('.modal-warning #form-edit-pembelian').html(result);
						$('.select2').select2();
  					}
  				});
			}
		}
	}
	var editReck_ = new editReck();
	dot.addData('editReck', editReck_);
})( observer );

function getChange(e){
	var id_barang = $(e).val();
	ajaxRequest({
				url:Datadefine['url']+"index.php/c_pembelian/ambil_tampil_barang",
				type:'get',
				data:"id="+id_barang,
				beforeSend:function(){
					$('.modal-warning .loader').html('<i>Loading...</i>');
				},
				success:function(result){
					let data = JSON.parse(result);
					var jumlah = parseInt($('#form-jumlah').val());
					var harga = parseInt(data.harga_beli);
					var total_harga = jumlah * harga;
					$('#form-harga').val(total_harga);
					$('#form-supplier').val(data.nama_supplier);
					$('#form-satuan').val(data.satuan);
					$('.modal-warning .loader').html('');
				}
			});
}

$('#update').click(function(e){
	ajaxRequest({
		type:'get',
		url:Datadefine['url']+"index.php/c_pembelian/edit_data_pembelian_detail",
		data:$('.modal-warning #form-edit-pembelian').serialize(),
		beforeSend:function(){
			$('.modal-warning .loader').html('<i>Sedang Menyimpan Perubahan...</i>');
		},success:function(result){
			var data = JSON.parse(result);
			if(data.result == "sukses"){
				$('.modal-warning .loader').html('');
			}
		}
	});
});

$('#delete').click(function(e){
	ajaxRequest({
		type:'GET',
		url:Datadefine['url']+"index.php/c_pembelian/hapus_pembelian_detail",
		data:$('.modal-danger #form-hapus-pembelian').serialize(),
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
(function(dot){
	var getTambah = function(){
		return {
			result:function(){
				var btn = arguments[0];
				let id = arguments[0].target.parentNode.parentNode.children[0].innerHTML;
				let jumlah = arguments[0].target.parentNode.parentNode.children[3].innerHTML
				ajaxRequest({
					type: "GET",
	          		url: Datadefine['url']+"index.php/c_pembelian/tambah_stok_barang",
	          		data:"id="+id+"&jumlah="+jumlah,
	          		beforeSend:function(){
	          			btn.target.disabled = true;
						btn.target.innerHTML = 'Loading...';
	          		},
	          		success:function( result ){
						btn.target.disabled = false;
						if(JSON.parse(result).result == "sukses"){
							btn.target.classList.remove('btn-primary');
							btn.target.classList.remove('fa-plus');
							btn.target.classList.add('btn-success');
							btn.target.classList.add('fa-check')
							btn.target.attributes.removeNamedItem('data-cstarget');
							btn.target.innerHTML = "&nbsp;&nbsp;Ditambahkan";
						}else{
							btn.target.disabled = false;
							btn.target.innerHTML = 'Tambahkan';
						}
	          		}
				});
			}
		}
	}
	var getTambah_ = new getTambah();
	dot.addData('getTambah', getTambah_);
})( observer );

$('#refresh-barang').click(function(e){
	var updateIndexData = function(){
		var jumlah = $('.tampil-barang tbody tr').length;
			$('#ket-index-data')
			.html('<p>Menampilkan <strong>'+jumlah+'</strong> dari <strong>'+Datadefine['count-data']+'</strong> data. </p>');
	},
	updatePageMoreBtn = function(){
		$('#page-more').html('<button type="button" class="btn btn-default btn-block btn-more" data-cstarget="pageMore">Tampilkan Lagi</button>');
	}
	ajaxRequest({
		type:'get',
		url:Datadefine['url']+"index.php/c_function/refresh_daftar_barang_beli_detail",
		data:"tanggal="+Datadefine['tanggal'],
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