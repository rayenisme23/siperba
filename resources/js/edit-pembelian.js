function editFunc(id) {
$.ajax({
type: "POST",
url: "{{ url('pembelian-edit') }}",
data: {
id: id
},
dataType: 'json',
success: function(res) {
console.log(res.pembelian);
$('#editModal').modal('show');
$('#id').val(res.pembelian.id);
$('#edit_namauser').text(res.pembelian.user[0].nama_user);
$('#edit_nopo').text(res.pembelian.no_po);
$('#edit_tanggal').text(res.tanggal);
$('#edit_supplier_id').val(res.pembelian.supplier_id);
$('#qty').val(res.qty);

function formatRupiah(angka) {
var number_string = angka.toString().replace(/[^,\d]/g, ''),
split = number_string.split(','),
sisa = split[0].length % 3,
rupiah = split[0].substr(0, sisa),
ribuan = split[0].substr(sisa).match(/\d{3}/gi);

if (ribuan) {
separator = sisa ? '.' : '';
rupiah += separator + ribuan.join('.');
}

rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
return 'Rp ' + rupiah;
}

// function calculateTotal() {
// let subtotal = 0;

// $('.total').each(function() {
// subtotal += parseFloat($(this).data('value'));
// });

// // Append new total row
// var totalHtml = "<tbody id='totalRow'>"
    // totalHtml += "<tr>"
        // totalHtml += "<td colspan='4' class='text-right'>Subtotal:</td>"
        // totalHtml += "<td id='subtotal' data-value='" + subtotal + "'>" + formatRupiah(
            // subtotal) + "</td>"
        // totalHtml += "<td></td>"
        // totalHtml += "</tr>"
    // totalHtml += "</tbody>"

// $('#editpembelianTable').append(totalHtml);
// }
$.each(res.items, function(key, item) {
let baris = 0;
var html = "<tbody>"
html += "<tr id='baris_edit" + baris + "'>";
    html += "<td>" + item.nama_bahanbaku + "</td>";
    html += "<td>" + item.qty + "</td>";
    html += "<td>" + formatRupiah(item.harga) + "</td>";
    html += "<td>" + formatRupiah(item.total) + "</td>";
    html += "<td><button class='btn btn-sm btn-danger' id='hapus' data-row='baris_edit" + baris +"'>-</button></td>";
    html += "</tr>";
html += "</tbody>"
$('#editpembelianTable').append(html);
// calculateTotal();
});
},
error: function(xhr) {
$('.error').text('');

var errors = xhr.responseJSON.errors;

if (errors) {
$.each(errors, function(key, value) {
$('#error_' + key).text(value[0]);
});
} else {
Swal.fire({
title: "Gagal!",
text: xhr.responseJSON.error || "Terjadi kesalahan. Silakan coba lagi.",
icon: "error"
});
}
}
});
}
