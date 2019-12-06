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
				var url = Datadefine['url']+"index.php/c_pembelian/panggil_data_daftar_pembelian_lanjut";
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
		url:Datadefine['url']+"index.php/c_function/refresh_daftar_pembelian",
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
				let tanggal = arguments[0].target.parentNode.parentNode.children[5].innerHTML;
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
		url:Datadefine['url']+"index.php/c_function/hapus_daftar_pembelian",
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

