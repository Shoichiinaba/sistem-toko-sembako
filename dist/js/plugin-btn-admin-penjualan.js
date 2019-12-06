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
  				id = element.target.attributes.alt.value,
  				url = Datadefine['url']+"index.php/c_penjualan/tampil_data_penjualan";
  				ajaxRequest({
  					url:url,
  					data:'id='+id,
  					type:'GET',
  					beforeSend:function(){
  						$('.tabel-penjualan-ket').hide();
  						$('.modal-body').append('<p>Loading...</p>');
  					},
  					success:function(result){
  						var data = JSON.parse(result);
  						data = data[0];
  						$('.modal-id').html(data.id);
  						$('.modal-barang').html(data.deskripsi_barang);
  						$('.modal-harga').html(data.total_harga);
  						$('.modal-pembayaran').html(data.pembayaran);
  						$('.modal-kembalian').html(data.kembalian);
  						$('.modal-tanggal').html(data.tanggal);
  						$('.tabel-penjualan-ket').show();
  						$('.modal-body p').remove();
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
				var btn = arguments[0].target;
				Datadefine['index-hal']++;
				if(Datadefine['penjualan'] == 'detail'){
					var url = Datadefine['url']+"index.php/c_penjualan/panggil_data_penjualan_detail?tgl="+Datadefine['tanggal'];
				}else{
					var url = Datadefine['url']+"index.php/c_penjualan/panggil_data_penjualan";
				}
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
					url:Datadefine['url']+"index.php/c_penjualan/cari_penjualan",
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
})( observer );

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
	          		url: Datadefine['url']+"index.php/c_penjualan/cari_penjualan_lanjut",
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

$('#refresh-barang').click(function(e){
	var updateIndexData = function(){
		var jumlah = $('.tampil-barang tbody tr').length;
			$('#ket-index-data')
			.html('<p>Menampilkan <strong>'+jumlah+'</strong> dari <strong>'+Datadefine['count-data']+'</strong> data. </p>');
	},
	updatePageMoreBtn = function(){
		$('#page-more').html('<button type="button" class="btn btn-default btn-block btn-more" data-cstarget="pageMore">Tampilkan Lagi</button>');
	}
	var URL = (Datadefine['penjualan'] != 'detail') ? Datadefine['url']+"index.php/c_penjualan/refresh_data_penjualan" : Datadefine['url']+"index.php/c_penjualan/refresh_data_penjualan_detail?tgl="+Datadefine['tanggal'];
	ajaxRequest({
		type:'get',
		url:URL,
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

(function(dot){
	var delPick = function(){
		return {
			result:function(){
				let tanggal = arguments[0].target.parentNode.parentNode.children[3].innerHTML;
				if(typeof objectDel_ === "undefined"){
					objectDel_ = arguments[0].target.parentNode.parentNode;
				}else{
					delete objectDel_;
					objectDel_ = arguments[0].target.parentNode.parentNode;
				}
				$('.modal-danger .modal-body input').val(tanggal);
			}
		}
	}
	var delPick_ = new delPick();
	dot.addData('delPick', delPick_);
})(observer);

$('#delete').click(function(e){
	ajaxRequest({
		type:'get',
		url:Datadefine['url']+"index.php/c_penjualan/hapus_data_penjualan",
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
			}else{
				alert('Sistem gagal menghapus');
				$('.modal-danger #tutup').click();
				$('.modal-danger .loader').empty();
			}
		}
	})
});

 $('#datepicker').datepicker({
      autoclose: true,
	  format: 'dd/mm/yyyy'
 });
 $('#datepicker2').datepicker({
      autoclose: true,
	  format: 'dd/mm/yyyy'
 });
