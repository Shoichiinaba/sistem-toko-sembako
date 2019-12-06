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
				var url = Datadefine['url']+"index.php/c_pembelian/panggil_data_barang_masuk";
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
					cari = $('.fil-cari').val();
				ajaxRequest({
					type:'get',
					url:Datadefine['url']+"index.php/c_pembelian/pencarian_data_barang_masuk",
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
				let cari = Datadefine['cari'];
				Datadefine['index-hal']++;
				ajaxRequest({
					type: "get",
	          		url: Datadefine['url']+"index.php/c_pembelian/pencarian_data_barang_masuk_next",
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

(function(dot){
	var getCheck = function(){
		return {
			result:function(){
				var btn = arguments[0];
				let id = btn.target.attributes.alt.value;
				ajaxRequest({
					type: "get",
	          		url: Datadefine['url']+"index.php/c_pembelian/data_barang_masuk_terima",
	          		data:"id="+id,
	          		beforeSend:function(){
	          			btn.target.disabled = true;
						btn.target.innerHTML = 'Loading...';
	          		},
	          		success:function( result ){
						btn.target.disabled = false;
						if(JSON.parse(result).status == "success"){
							btn.target.classList.remove('btn-primary');
							btn.target.classList.add('btn-success');
							btn.target.attributes.removeNamedItem('data-cstarget');
						}
						btn.target.innerHTML = "&nbsp;&nbsp;Diterima";
	          		}
				});
			}
		}
	}
	var getCheck_ = new getCheck();
	dot.addData('getCheck', getCheck_);
})( observer );