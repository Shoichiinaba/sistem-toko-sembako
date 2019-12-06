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
				var url = Datadefine['url']+"index.php/c_function/panggil_data_barang_beli";
				ajaxRequest({
					type: "get",
	          		url: url,
	          		data:"index="+getHal()+"&length="+pageLength,
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
				let btn = arguments[0].target;
				let atribut = Datadefine['atribut'];
				let cari = Datadefine['cari'];
				Datadefine['index-hal']++;
				ajaxRequest({
					type: "get",
	          		url: Datadefine['url']+"index.php/c_function/pencarian_data_barang_beli_next",
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
				var atribut = $('.fil-atr').val(),
					cari = $('.fil-cari').val();
				ajaxRequest({
					type:'get',
					url:Datadefine['url']+"index.php/c_function/pencarian_data_barang_beli",
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
		url:Datadefine['url']+"index.php/c_function/refresh_barang_beli",
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

$('#kirim-barang').click(function(e){
	e.preventDefault();
	var form_data = $('.modal-primary #form-input-barang').serialize();
	var URL = Datadefine['url']+'index.php/c_function/input_data_barang_beli';
	ajaxRequest({
		type:'post',
		url:URL,
		data:form_data,
		beforeSend:function(){
			$('#loading').html('<i>Loading...</i>');
		},
		success:function(result){
			var data = JSON.parse(result);
			if(data.result){
				$('#loading').children().remove();
				$('.modal-primary #tutup').click();
				$('.modal-primary #form-input-barang')[0].reset();
			}else{
				alert('sepertinya sistem server mengalami masalah saat diakses');
			}
		}
	});
});
(function(dot){
	var editReck = function(){
		return {
			result:function(){
				var element = arguments[0],
  				id = element.target.parentNode.parentNode.children[0].innerHTML,
				nama = element.target.parentNode.parentNode.children[1].innerHTML,
				kategori = element.target.parentNode.parentNode.children[2].innerHTML,
				harga = element.target.parentNode.parentNode.children[3].innerHTML,
				supplier = element.target.parentNode.parentNode.children[4].innerHTML,
  				url = Datadefine['url']+"index.php/c_function/tampil_edit_barang_beli";
  				ajaxRequest({
  					type:'get',
  					url:url,
  					data:'id_barang='+id+'&nama_barang='+nama+'&kategori='+kategori+'&harga='+harga+'&supplier='+supplier,
  					beforeSend:function(){
  						$('.modal-warning #form-input-barang').html('<p>Loading...</p>');
  					},
  					success:function(result){
  						$('.modal-warning #form-input-barang').html(result);
  					}
  				});
			}
		}
	}
	var editReck_ = new editReck();
	dot.addData('editReck', editReck_);
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

$('#delete').click(function(e){
	ajaxRequest({
		type:'get',
		url:Datadefine['url']+"index.php/c_function/hapus_barang_beli",
		data:$('.modal-danger #form-hapus-barang').serialize(),
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

$('#update').click(function(e){
	ajaxRequest({
		type:'get',
		url:Datadefine['url']+"index.php/c_function/update_barang_beli",
		data:$('.modal-warning #form-input-barang').serialize(),
		beforeSend:function(){
			$('.modal-warning .loader').html('<p>Sedang Menyimpan Perubahan...</p>');
		},success:function(result){
			var data = JSON.parse(result);
			if(data.result == "sukses"){
				$('.modal-warning .loader > p').remove();
			}
		}
	});
});
