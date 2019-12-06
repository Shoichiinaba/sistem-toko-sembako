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
  var resultGet = function(){
  	return {
  		result:function(){
  			if(arguments.length){
  				var element = arguments[0],
  				id = element.target.parentNode.parentNode.children[0].innerHTML,
  				url = Datadefine['url']+"index.php/c_master_barang/info_barang";
  				ajaxRequest({
  					url:url,
  					data:'id='+id,
  					type:'GET',
  					beforeSend:function(){
  						$('.tabel-barang-ket').hide();
  						$('.modal-body').append('<p>Loading...</p>');
  					},
  					success:function(result){
  						var jsonP = JSON.parse(result);
  						var id_barang = jsonP.hasil[0].id_barang,
  							nama_barang = jsonP.hasil[0].nama_barang,
							kategori = jsonP.hasil[0].kategori,
  							harga_jual = jsonP.hasil[0].harga_jual,
							harga_beli = jsonP.hasil[0].harga_beli,
  							jumlah_stok = jsonP.hasil[0].jumlah_stok,
  							penempatan = jsonP.hasil[0].nama_penempatan,
  							supplier = jsonP.hasil[0].nama_supplier;
  							$('.modal-info .modal-id-barang').html(id_barang);
  							$('.modal-info .modal-nama-barang').html(nama_barang);
							$('.modal-info .modal-kategori').html(kategori);
  							$('.modal-info .modal-harga-jual').html(harga_jual);
							$('.modal-info .modal-harga-beli').html(harga_beli);
  							$('.modal-info .modal-jumlah-stok').html(jumlah_stok);
  							$('.modal-info .modal-penempatan').html(penempatan);
  							$('.modal-info .modal-supplier').html(supplier);
  							$('.modal-info .tabel-barang-ket').show();
  							$('.modal-info .modal-body p').remove();
  					}
  				});
  			}
  		}
  	}
  }
  var resultGet_ = new resultGet();
  dot.addData('resultGet', resultGet_);
})( observer );



(function(dot){
	var pageMore = function(){
		var index = 1,
		pageLength = 8,
		maxHal = Datadefine['maksimal-hal'],
		getHal = () => (index * pageLength) - pageLength,
		getUpdateHal = function(e)
		{
			if(index >= maxHal)
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
				index++;
				var url = Datadefine['url']+"index.php/c_master_barang/tampil_barang_lanjut";
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
					var cari = $('.fil-cari').val();
				ajaxRequest({
					type:'get',
					url:Datadefine['url']+"index.php/c_master_barang/cari_barang",
					data:'cari='+cari,
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
						Datadefine['cari'] = cari;
					}
				});
			}
		}
	}
	var searchNpage_ = new searchNpage();
	dot.addData('searchNpage', searchNpage_);
})(observer);

(function(dot){
	var pageMoresearch = function(){
		var pageLength = 8,
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
				let cari = Datadefine['cari'];
				Datadefine['index-hal']++;
				ajaxRequest({
					type: "get",
	          		url: Datadefine['url']+"index.php/c_master_barang/cari_barang_lanjut",
	          		data:"cari="+cari+"&index="+getHal()+"&length="+pageLength,
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