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
		maxHal = Datadefine['maksimal-hal'],
		getHal = () => (Datadefine['index-hal'] * pageLength) - pageLength,
		getUpdateHal = function(e)
		{
			if(Datadefine['index-hal'] >= Datadefine['maksimal-hal'])
				$(e).hide();
		},
		updateKetdata = function(){
			var jumlah = $('.tampil-jenis tbody tr').length;
			$('#ket-index-data')
			.html('<p>Menampilkan <strong>'+jumlah+'</strong> dari <strong>'+Datadefine['count-data']+'</strong> data. </p>');
		}
		return {
			result:function(){
				var btn = arguments[0].target;
				Datadefine['index-hal']++;
				var url = Datadefine['url']+"index.php/c_function/panggil_data_jenis";
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
	          			$('.tampil-jenis tbody').append( data.data );
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
				var id = arguments[0].target.parentNode.parentNode.children[0].innerHTML;
				var nama = arguments[0].target.parentNode.parentNode.children[1].innerHTML;
				var keterangan = arguments[0].target.parentNode.parentNode.children[2].innerHTML;
				$('.modal-warning #form-input-jenis .id').val(id);
				$('.modal-warning #form-input-jenis .nama').val(nama);
				$('.modal-warning #form-input-jenis .keterangan').val(keterangan);
				
			}
		}
	}
	var editReck_ = new editReck();
	dot.addData('editReck', editReck_);
})( observer );

$('#kirim').click(function(e){
	e.preventDefault();
	var form_data = $('.modal-primary #form-input-jenis').serialize();
	var URL = Datadefine['url']+'index.php/c_function/input_data_jenis';
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
				$('.modal-primary #form-input-jenis')[0].reset();
			}else{
				alert('sepertinya sistem server mengalami masalah saat diakses');
			}
		}
	});
});
$('#update').click(function(e){
	ajaxRequest({
		type:'get',
		url:Datadefine['url']+"index.php/c_function/update_jenis",
		data:$('.modal-warning #form-input-jenis').serialize(),
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

$('#delete').click(function(e){
	ajaxRequest({
		type:'get',
		url:Datadefine['url']+"index.php/c_function/hapus_jenis",
		data:$('.modal-danger #form-hapus-jenis').serialize(),
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
		var jumlah = $('.tampil-jenis tbody tr').length;
			$('#ket-index-data')
			.html('<p>Menampilkan <strong>'+jumlah+'</strong> dari <strong>'+Datadefine['count-data']+'</strong> data. </p>');
	},
	updatePageMoreBtn = function(){
		$('#page-more').html('<button type="button" class="btn btn-default btn-block btn-more" data-cstarget="pageMore">Tampilkan Lagi</button>');
	}
	ajaxRequest({
		type:'get',
		url:Datadefine['url']+"index.php/c_function/refresh_jenis",
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
				$('table.tampil-jenis tbody').html(r.data);
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