$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    let alatData = JSON.parse(opsiAlat);
    let plpData = JSON.parse(opsiPlp);
    let bahanData = JSON.parse(opsiBahan);
    // Event: Tambah Booking Peminjaman
    $("#tambahItemAlat").click(function () {
        if ($(".itemListAlat .item").length >= 10) {
            toastr.warning("Maksimal 10 alat dapat dipinjam!", "Peringatan!");
            return;
        }
        let newItem = `
            <li class="item">
                <div class="form-group mandatory">
                    <label for="plpAlat" class="form-label">Pilih PLP</label>
                    <select name="plpAlat[]" class="form-select plpSelect">
                        <option value="">-- Pilih PLP --</option>
                        ${plpOptions()}
                    </select>
                </div>
                <div class="form-group mandatory">
                    <label for="lokasiAlat" class="form-label">Lokasi</label>
                    <small class="text-muted">Jika Pilih Lab Maka Stok Dari PLP, Jika Pilih Gudang Maka Stok Dari Gudang Pusat</small>
                    <select name="lokasiAlat[]" class="form-select lokasiSelect">
                        <option value="">-- Pilih Lokasi --</option>
                        <option value="Lab">Lab</option>
                        <option value="Gudang">Gudang</option>
                    </select>
                </div>
                                    
                <div class="row">
                    <div class="col-sm-6 mb-1">
                        <div class="form-group mandatory">
                            <label for="namaAlat" class="form-label">Nama Alat</label>
                            <select name="namaAlat[]" class="form-select alatSelect">
                                <option value="">-- Pilih Alat --</option>
                                ${alatOptions()}
                            </select>
                        </div>
                    </div>
                                            
                    <div class="col-sm-3 mb-1">
                        <div class="form-group mandatory">
                            <label for="tersedia" class="form-label">Stok Tersedia</label>
                            <input type="number" name="tersedia[]" class="form-control stokTersedia" readonly>
                        </div>
                    </div>
                    <div class="col-sm-3 mb-1">
                        <div class="form-group mandatory">
                            <label for="jumlahAlat" class="form-label">Jumlah Pinjam</label>
                            <input type="number" name="jumlahAlat[]" min="1" class="form-control jumlahAlat" value="0">
                        </div>
                    </div>
                </div>    
                <div class="col-sm-3 mb-1">
                    <div class="input-group">
                        <button class="btn btn-danger hapusItemAlat" type="button">Hapus</button>
                    </div>
                </div>
            </li>
            `;
            
        $(".itemListAlat").append(newItem);
    });

    // Event: Ambil Stok saat pilihan berubah
    $(document).on("change", ".plpSelect, .lokasiSelect, .alatSelect", function(){
        let item = $(this).closest(".item");
        let plp_id = item.find(".plpSelect").val();
        let lokasi = item.find(".lokasiSelect").val();
        let kd_alat = item.find(".alatSelect").val();
        let stokTersediaInput = item.find(".stokTersedia");

        if (plp_id && lokasi && kd_alat) {
            $.ajax({
                url: "/get-stok/alat",
                type: "GET",
                data: { plp_id: plp_id, lokasi: lokasi, kd_alat: kd_alat },
                success: function (response) {
                    stokTersediaInput.val(response.stok);
                }
            });
        }
    });

    // Event : Hapus Item
    $(document).on("click", ".hapusItemAlat", function(){
        $(this).closest(".item").remove();
    });

    // Event : tambah item bahan
    $("#tambahItemBahan").click(function () {
        if ($(".itemListBahan .item").length >= 10) {
            toastr.warning("Maksimal 10 bahan dapat dipinjam!", "Peringatan!");
            return;
        }
        let newItem = `
            <li class="item">
                <div class="form-group mandatory">
                    <label for="plpBahan" class="form-label">Pilih PLP</label>
                    <select name="plpBahan[]" class="form-select plpSelect">
                        <option value="">-- Pilih PLP --</option>
                        ${plpOptions()}
                    </select>
                </div>
                <div class="form-group mandatory">
                    <label for="lokasiBahan" class="form-label">Lokasi</label>
                    <small class="text-muted">Jika Pilih Lab Maka Stok Dari PLP, Jika Pilih Gudang Maka Stok Dari Gudang Pusat</small>
                    <select name="lokasiBahan[]" class="form-select lokasiSelect">
                        <option value="">-- Pilih Lokasi --</option>
                        <option value="Lab">Lab</option>
                        <option value="Gudang">Gudang</option>
                    </select>
                </div>
                                
                <div class="row">
                    <div class="col-sm-6 mb-1">
                        <div class="form-group mandatory">
                            <label for="namaBahan" class="form-label">Nama Bahan</label>
                            <select name="namaBahan[]" class="form-select bahanSelect">
                                <option value="">-- Pilih Bahan --</option>
                                ${bahanOptions()}
                            </select>
                        </div>
                    </div>
                                        
                    <div class="col-sm-3 mb-1">
                        <div class="form-group mandatory">
                            <label for="tersedia" class="form-label">Stok Tersedia</label>
                            <input type="number" name="tersedia[]" class="form-control stokBahanTersedia" readonly>
                        </div>
                    </div>
                    <div class="col-sm-3 mb-1">
                        <div class="form-group mandatory">
                            <label for="jumlahBahan" class="form-label">Jumlah Pinjam</label>
                            <input type="number" name="jumlahBahan[]" min="1" class="form-control jumlahBahan" value="0">
                        </div>
                    </div>
                </div>    
                <div class="col-sm-3 mb-1">
                    <div class="input-group">
                        <button class="btn btn-danger hapusItemBahan" type="button">Hapus</button>
                    </div>
                </div>
            </li>
            `;
        
        $(".itemListBahan").append(newItem);
    });

    // Event: Ambil Stok saat pilihan berubah
    $(document).on("change", ".plpSelect, .lokasiSelect, .bahanSelect", function(){
        let item = $(this).closest(".item");
        let plp_id = item.find(".plpSelect").val();
        let lokasi = item.find(".lokasiSelect").val();
        let kd_bahan = item.find(".bahanSelect").val();
        let stokTersediaInput = item.find(".stokBahanTersedia");

        if (plp_id && lokasi && kd_bahan) {
            $.ajax({
                url: "/get-stok/bahan",
                type: "GET",
                data: { plp_id: plp_id, lokasi: lokasi, kd_bahan: kd_bahan },
                success: function (response) {
                    stokTersediaInput.val(response.stok);
                }
            });
        }
    });

    // Event : Hapus Item
    $(document).on("click", ".hapusItemBahan", function(){
        $(this).closest(".item").remove();
    });

    // Event: Validasi Jumlah Pinjam agar tidak melebihi stok
    $(document).on("input", ".jumlahAlat, .jumlahBahan", function () {
        let item = $(this).closest(".item");
        
        // Pastikan opsiSelect terbaca dengan benar setiap kali ada input
        let opsi = $(".opsiSelect").val(); 
        let kd_alat = item.find(".alatSelect").val() || null;
        let kd_bahan = item.find(".bahanSelect").val() || null;
        let lokasi = item.find(".lokasiSelect").val();
        let jumlahPinjam = parseInt($(this).val()) || 0;

        // Validasi untuk alat (Peminjaman)
        if ((opsi === "Peminjaman" || opsi === "PP") && kd_alat) {
            let stokTersediaAlat = parseInt(item.find(".stokTersedia").val()) || 0;
            let totalDipilihAlat = 0;

            $(".itemListAlat .item").each(function () {
                let alat = $(this).find(".alatSelect").val();
                let lok = $(this).find(".lokasiSelect").val();
                let jumlah = parseInt($(this).find(".jumlahAlat").val()) || 0;

                if (alat === kd_alat && lok === lokasi) {
                    totalDipilihAlat += jumlah;
                }
            });

            if (totalDipilihAlat > stokTersediaAlat) {
                let stokSisa = stokTersediaAlat - (totalDipilihAlat - jumlahPinjam);
                toastr.warning("Jumlah alat melebihi stok tersedia! Sisa stok: " + stokSisa, "Peringatan!");
                $(this).val(stokSisa > 0 ? stokSisa : 0);
            }
        }

        // Validasi untuk bahan (Permintaan)
        if ((opsi === "Permintaan" || opsi === "PP") && kd_bahan) {
            let stokTersediaBahan = parseInt(item.find(".stokBahanTersedia").val()) || 0;
            let totalDipilihBahan = 0;

            $(".itemListBahan .item").each(function () {
                let bahan = $(this).find(".bahanSelect").val();
                let lok = $(this).find(".lokasiSelect").val();
                let jumlah = parseInt($(this).find(".jumlahBahan").val()) || 0;

                if (bahan === kd_bahan && lok === lokasi) {
                    totalDipilihBahan += jumlah;
                }
            });

            if (totalDipilihBahan > stokTersediaBahan) {
                let stokSisa = stokTersediaBahan - (totalDipilihBahan - jumlahPinjam);
                toastr.warning("Jumlah bahan melebihi stok tersedia! Sisa stok: " + stokSisa, "Peringatan!");
                $(this).val(stokSisa > 0 ? stokSisa : 0);
            }
        }
    });

    // Fungsi untuk generate opsi alat berdasarkan Laravel
    function alatOptions() {
        let options = "";
        alatData.forEach(a => {
            options += `<option value="${a.id}">${a.nama_alat}</option>`;
        });
        return options;
    }
    // Fungsi untuk generate opsi plp berdasarkan Laravel
    function plpOptions() {
        let options = "";
        plpData.forEach(a => {
            options += `<option value="${a.id}">${a.nama}</option>`;
        });
        return options;
    }
    // Fungsi untuk generate opsi Bahan berdasarkan Laravel
    function bahanOptions() {
        let options = "";
        bahanData.forEach(a => {
            options += `<option value="${a.id}">${a.nama_bahan}</option>`;
        });
        return options;
    }

});
function giveSelection(selValue) {
		if (selValue ==='Peminjaman') {
			document.getElementById("input_peminjaman").style.display = 'block';
			document.getElementById("input_permintaan").style.display = 'none';
		}
		else if (selValue ==='Permintaan') {
			document.getElementById("input_peminjaman").style.display = 'none';
			document.getElementById("input_permintaan").style.display = 'block';
		}
		else if (selValue ==='PP') {
			document.getElementById("input_peminjaman").style.display = 'block';
			document.getElementById("input_permintaan").style.display = 'block';
		}
		else{
			document.getElementById("input_peminjaman").style.display = 'none';
			document.getElementById("input_permintaan").style.display = 'none';
		}
  	}