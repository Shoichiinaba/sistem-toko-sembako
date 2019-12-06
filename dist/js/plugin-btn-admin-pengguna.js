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
			var jumlah = $('.tampil-supplier tbody tr').length;
			$('#ket-index-data')
			.html('<p>Menampilkan <strong>'+jumlah+'</strong> dari <strong>'+Datadefine['count-data']+'</strong> data. </p>');
		}
		return {
			result:function(){
				var btn = arguments[0].target;
				Datadefine['index-hal']++;
				var url = Datadefine['url']+"index.php/c_pengguna/panggil_data_pengguna";
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
	          			$('.tampil-pengguna tbody').append( data.data );
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
				let nama = arguments[0].target.parentNode.parentNode.children[1].innerHTML;
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

$('#kirim').click(function(e){
	e.preventDefault();
	var form = $('#modal-primary #form-input-pengguna');
	if(form[0].checkValidity()){
		ajaxRequest({
			type:'POST',
			url:Datadefine['url']+'index.php/c_pengguna/input_data_pengguna',
			data:form.serialize(),
			beforeSend:function(){
				$('#loading').html('<i>Loading...</i>');
			},
			success:function(result){
				var data = JSON.parse(result);
				if(data.result){
					$('#loading').children().remove();
					$('.modal-primary #tutup').click();
					$('.modal-primary #form-input-pengguna')[0].reset();
				}else{
					alert('sepertinya sistem server mengalami masalah saat diakses');
				}
			}
		});
	}else{
		alert('Semua wajib diisi !');
	}
});

$('#delete').click(function(e){
	ajaxRequest({
		type:'get',
		url:Datadefine['url']+"index.php/c_pengguna/hapus_pengguna",
		data:$('.modal-danger #form-hapus-pengguna').serialize(),
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