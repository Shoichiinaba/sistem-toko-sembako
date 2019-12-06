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

let komponenDataBarang = {
	jumlah:0,
	data:{},
};



$('.select2').select2()

$('#data_barang').change(function(){
	var get = $(this).val();
	if(get !== "null"){
		//
			ajaxRequest({
				url:Datadefine['url']+"index.php/c_pembelian/ambil_tampil_barang",
				type:'get',
				data:"id="+get,
				beforeSend:function(){
					$('#addData')[0].disabled = true;
				},
				success:function(result){
					let data = JSON.parse(result);
					$('#harga').val(data.harga_beli);
					$('#nama_supplier').val(data.nama_supplier);
					$('#nama_satuan').val(data.satuan);
					komponenDataBarang.data = data;
					$('#addData')[0].disabled = false;
				}
			});
		//
	}
});
(function(dot){
	var delPick = function(){
		return {
			result:function(e){
				var td = e.target.parentNode.parentNode;
				td.remove();
				komponenDataBarang.jumlah--;
				if(komponenDataBarang.jumlah < 1){
					$('#kirim').hide();
				}
			}
		}
	}
	var delPick_ = new delPick();
	dot.addData('delPick', delPick_);
})(observer);

$("#addData").click(function(e){
	// Digunakan untuk menambah data barang yang ada di tabel
	// daftar pembelian barang
	e.preventDefault();
	if(komponenDataBarang.data.id_barang != null){
		// eksekusi variabel atas ketersediaan nilai value pada
		// data id_barang
		$('table.tampil-barang tbody').append(stringTambah());
		komponenDataBarang.jumlah++;
		if($('#kirim')[0].style.display == 'none'){
			if(komponenDataBarang.jumlah >= 1){
				$('#kirim').show();
			}
		}
	}
});

function stringTambah(){
	let nomor = komponenDataBarang.jumlah + 1,
		id_barang = komponenDataBarang.data.id_barang,
		nama_barang = komponenDataBarang.data.nama_barang,
		satuan = komponenDataBarang.data.satuan,
		jumlah = parseInt($('#jumlah').val()),
		harga = parseInt(komponenDataBarang.data.harga_beli) * jumlah,
		nama_supplier = komponenDataBarang.data.nama_supplier,
		alamat = komponenDataBarang.data.alamat,
		no_hp = komponenDataBarang.data.telp;
	let s = "";
	s+="<tr>";
	s+="<td>"+id_barang+"<input type='hidden' value='"+id_barang+"' name='id_barang[]'></td>";
	s+="<td>"+nama_barang+"</td>";
	s+="<td>"+satuan+"<input type='hidden' value='"+satuan+"' name='satuan[]'></td>";
	s+="<td>"+jumlah+"<input type='hidden' value='"+jumlah+"' name='jumlah[]'></td>";
	s+="<td>"+harga+"<input type='hidden' value='"+harga+"' name='harga[]'></td>";
	s+="<td>"+nama_supplier+"<input type='hidden' value='"+nama_supplier+"' name='nama_supplier[]'></td>";
	s+="<td>"+alamat+"<input type='hidden' value='"+alamat+"' name='alamat[]'></td>";
	s+="<td>"+no_hp+"<input type='hidden' value='"+no_hp+"' name='telp[]'><input type='hidden' name='tanggal[]' value='"+$('#tanggal').val()+"'></td>";
	s+='<td><input type="hidden" value="belum" name="acc[]"><input type="hidden" value="belum" name="status[]"><button type="button" data-toggle="modal" data-target="#modal-danger" data-cstarget="delPick" class="btn btn-danger fa fa-trash"></button></td>';
	s+="</tr>";
	return s;
}
$('#kirim').click(function(e){
	e.preventDefault();
	// event klik digunakan untuk mengirimkan semua data pembelian barang
	// ke database
	let url = Datadefine['url']+'index.php/admin/pembelian?alert=sukses';
	ajaxRequest({
		url:Datadefine['url']+'index.php/c_pembelian/simpan_data_pembelian_barang',
		type:'POST',
		data:$('#form-action').serialize(),
		beforeSend:function(){
			
		},
		success:function(result){
			console.log(result);
			window.location.href = url;
		}
	});
});


