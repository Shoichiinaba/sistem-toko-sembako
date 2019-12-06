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
			var jumlah = $('.tampil-penempatan tbody tr').length;
			$('#ket-index-data')
			.html('<p>Menampilkan <strong>'+jumlah+'</strong> dari <strong>'+Datadefine['count-data']+'</strong> data. </p>');
		}
		return {
			result:function(){
				var btn = arguments[0].target;
				Datadefine['index-hal']++;
				var url = Datadefine['url']+"index.php/c_penempatan/panggil_data_penempatan";
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
	          			$('.tampil-penempatan tbody').append( data.data );
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
				var kunci = arguments[0].target.parentNode.parentNode.children[3].innerHTML;
				$('.modal-warning #form-input-penempatan .id').val(id);
				$('.modal-warning #form-input-penempatan .nama').val(nama);
				$('.modal-warning #form-input-penempatan .keterangan').val(keterangan);
				$('.modal-warning #form-input-penempatan .kunci').val(kunci);
				
			}
		}
	}
	var editReck_ = new editReck();
	dot.addData('editReck', editReck_);
})( observer );

$('#kirim').click(function(e){
	e.preventDefault();
	var form_data = $('.modal-primary #form-input-penempatan').serialize();
	var URL = Datadefine['url']+'index.php/c_penempatan/input_data_penempatan';
	if($('.modal-primary #form-input-penempatan')[0].checkValidity()){
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
					$('.modal-primary #form-input-penempatan')[0].reset();
				}else{
					alert('sepertinya sistem server mengalami masalah saat diakses');
				}
			}
		});
	}else{
		alert('Semua harus diisi...');
	}
});
$('#update').click(function(e){
	ajaxRequest({
		type:'get',
		url:Datadefine['url']+"index.php/c_penempatan/ubah_penempatan",
		data:$('.modal-warning #form-input-penempatan').serialize(),
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
		url:Datadefine['url']+"index.php/c_penempatan/hapus_penempatan",
		data:$('.modal-danger #form-hapus-penempatan').serialize(),
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
		var jumlah = $('.tampil-penempatan tbody tr').length;
			$('#ket-index-data')
			.html('<p>Menampilkan <strong>'+jumlah+'</strong> dari <strong>'+Datadefine['count-data']+'</strong> data. </p>');
	},
	updatePageMoreBtn = function(){
		$('#page-more').html('<button type="button" class="btn btn-default btn-block btn-more" data-cstarget="pageMore">Tampilkan Lagi</button>');
	}
	ajaxRequest({
		type:'get',
		url:Datadefine['url']+"index.php/c_function/refresh_penempatan",
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
				$('table.tampil-penempatan tbody').html(r.data);
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