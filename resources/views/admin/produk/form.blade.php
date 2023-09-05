<x-modal data-backdrop="static" data-keyboard="false" size="modal-lg">
    <x-slot name="title">
        Tambah Data
    </x-slot>

    @method('POST')

    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="form-group">
                <label for="name">Nama Produk</label>
                <input type="text" class="form-control" name="name" autocomplete="off">
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="form-group">
                <label for="price">Kategori Produk</label>
                <select name="categories[]" id="categories" multiple class="form-control select2"
                    placeholder="Pilih kategori"></select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="form-group">
                <label for="price">Harga Produk</label>
                <input type="text" class="form-control" name="price" autocomplete="off" onkeyup="format_uang(this)"
                    min="0" value="0" placeholder="Rp">
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="form-group">
                <label for="stock">Stok Produk</label>
                <input type="number" class="form-control" name="stock" autocomplete="off" min="0"
                    value="0">
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="form-group">
                <label for="price">Pilih Satuan</label>
                <select name="unit" id="unit" class="select2" placeholder="Pilih satuan"></select>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-warning alert-dismissible">
                <h5 class="text-bold"><i class="icon fas fa-exclamation-triangle"></i> Informasi!</h5>
                file yang diupload wajib jpg,jpeg,png dan berukuran minimal 200kb maxsimal 2 mb
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="form-group">
                <label for="price">Diskripsi Singkat Produk</label>
                <textarea name="short_description" id="short_description" cols="30" rows="2" class="form-control"></textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="form-group">
                <label for="price">Diskripsi Produk</label>
                <textarea name="description" id="description" cols="8" rows="5" class="form-control"></textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <label for="product_image">File upload produk</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="product_image" name="product_image">
                        <label class="custom-file-label" for="product_image" id="file">Choose file</label>
                    </div>
                    <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-outline-primary" id="submitBtn">
            <span id="spinner-border" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <i class="fas fa-save mr-1"></i>
            Simpan</button>
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-times"></i>
            Close
        </button>
    </x-slot>
</x-modal>
