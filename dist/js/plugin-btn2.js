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
  				url = Datadefine['url']+"index.php/c_function/tampil_data_penjualan";
  				ajaxRequest({
  					url:url,
  					data:'id='+id,
  					type:'POST',
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
  						$('.modal-kasir').html(data.id_user);
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
		var index = 1,
		pageLength = 2,
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
				var url = Datadefine['url']+"index.php/c_function/panggil_data_penjualan";
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
	var searchTanggal = function(){
		var url = Datadefine['url']+'index.php/c_function/tampil_cari_penjualan';
		var updateKetdata = function(){
					var jumlah = $('.tampil-barang tbody tr').length;
					$('#ket-index-data')
					.html('<p>Menampilkan <strong>'+jumlah+'</strong> dari <strong>'+Datadefine['count-data']+'</strong> data. </p>');
		}
		return {
			result:function(){
				var btnIdentifier = arguments[0].target.id;
				if(btnIdentifier != 'bulan'){
					var tgl = $('#form-tanggal input.tanggal').val();
					$('#ket-pencarian').html(''
					+ '<p>Menampilkan penjualan barang pada tanggal '
					+ '<span class="label label-success">'+tgl+'</span></p>');
				}else{
					var tgl = $('#form-tanggal input.bulan').val();
					$('#ket-pencarian').html(''
					+ '<p>Menampilkan penjualan barang pada bulan '
					+ '<span class="label label-info">'+tgl+'</span></p>');
				}
				ajaxRequest({
					type:'get',
					url:url,
					data:'index='+tgl,
					beforeSend:function(){

					},
					success:function(result){
						var res = JSON.parse(result);
						if(res.maxhal){
							Datadefine['index-hal'] = 1;
							Datadefine['maksimal-hal'] = res.maxhal;
							$('#page-more button').remove();
							$('#page-more').html(''
								+' <button type="button" class="btn btn-default btn-block btn-more" data-cstarget="pageMoresearch">Tampilkan Lagi</button>');
						}else{
							$('#page-more button').remove();
						}
						Datadefine['count-data'] = res.countData;
						$('.tampil-barang tbody').html(res.result);
						updateKetdata();
					}
				});
			}
		}
	}
	var searchTanggal_ = new searchTanggal();
	dot.addData('searchTanggal',searchTanggal_);
})(observer);

(function(dot){
	var pageMoresearch = function(){
		var pageLength = 2;
		var URL = Datadefine['url']+"index.php/c_function/panggil_data_cari_penjualan";
		var getHal = () => (Datadefine['index-hal'] * pageLength) - pageLength;
		var getUpdateHal = function(e)
		{
			if(Datadefine['index-hal'] >= Datadefine['maksimal-hal'])
				$(e).hide();
		}
		var updateKetdata = function(){
			var jumlah = $('.tampil-barang tbody tr').length;
			$('#ket-index-data')
			.html('<p>Menampilkan <strong>'+jumlah+'</strong> dari <strong>'+Datadefine['count-data']+'</strong> data. </p>');
		}
		return {
			result:function(){
				Datadefine['index-hal']+=1;
				var btn = arguments[0].target;
				var cari = $('#ket-pencarian span').html();
				ajaxRequest({
					type:'get',
					url:URL,
					data:"index="+getHal()+"&length="+pageLength+"&cari="+cari,
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
})(observer)

$('[data-mask]').inputmask();