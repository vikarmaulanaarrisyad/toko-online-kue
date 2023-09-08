@extends('layouts.app')

@section('title', 'Produk')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Daftar produk</li>
@endsection

@push('css')
    <style>
        /* [1] The container */
        .img-hover-zoom {
            /* [1.1] Set it as per your need */
            overflow: hidden;
            /* [1.2] Hide the overflowing of child elements */
        }

        /* [2] Transition property for smooth transformation of images */
        .img-hover-zoom img {
            transition: transform .5s ease;
        }

        /* [3] Finally, transforming the image when container gets hovered */
        .img-hover-zoom:hover img {
            transform: scale(1.5);
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <x-card>
                <x-slot name="header">
                    <button onclick="addForm(`{{ route('produk.store') }}`)" class="btn btn-outline-primary btn-sm"><i
                            class="fas fa-plus-circle"></i> Tambah Data</button>
                </x-slot>
                <x-table class="table-bordered">
                    <x-slot name="thead">
                        <tr>
                            <th style="width: 5%;" class="text-center">No</th>
                            <th style="width: 300px;" class="text-center">Gambar Produk</th>
                            <th class="text-center">Nama Produk</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Stok</th>
                            <th class="text-center">Satuan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>

    @includeIf('admin.produk.form')
@endsection

@includeIf('includes.select2')
@includeIf('includes.datatables')

@push('scripts')
    <script>
        let table;
        let modal = '#modal-form';
        let button = '#submitBtn';

        table = $('.table').DataTable({
            ordering: false,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('produk.data') }}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false,
                    className: 'text-center'
                },
                {
                    data: 'product_image',
                    searchable: false,
                    sortable: false,
                    className: 'text-center'
                },
                {
                    data: 'name'
                },
                {
                    data: 'price',
                    className: 'text-right'
                },
                {
                    data: 'stock',
                    className: 'text-center'
                },
                {
                    data: 'satuan',
                    className: 'text-center'
                },
                {
                    data: 'aksi',
                    sortable: false,
                    searchable: false
                },
            ]
        });

        function addForm(url, name = "Tambah Daftar Produk") {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(name);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('POST');
            $('#spinner-border').hide();
            $(button).prop('disabled', false);
            resetForm(`${modal} form`);
            $('#categories').val([]).trigger('change');
            $('#unit').val([]).trigger('change');
        }

        function editForm(url, title = 'Edit Data Produk') {
            $.get(url)
                .done(response => {
                    $(modal).modal('show');
                    $(`${modal} .modal-title`).text(title);
                    $(`${modal} form`).attr('action', url);
                    $(`${modal} [name=_method]`).val('PUT');
                    $('#spinner-border').hide();
                    $(button).prop('disabled', false);
                    resetForm(`${modal} form`);

                    let unit = response.data.satuan;

                    // Clear existing options in the Select2 dropdown
                    $('#categories').empty();

                    response.data.categories.forEach(function(category) {
                        var option = new Option(category.name, category.id, true, true);
                        $('#categories').append(option).trigger('change');
                    });
                    // Clear and update the Select2 dropdown with the single unit
                    $('#unit').empty().append(new Option(unit.name, unit.id, true, true)).trigger('change');

                    loopForm(response.data);

                })
                .fail(errors => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Opps! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: true,
                    });
                    $('#spinner-border').hide();
                    $(button).prop('disabled', false);
                });
        }

        function submitForm(originalForm) {
            $(button).prop('disabled', true);
            $('#spinner-border').show();
            $.post({
                    url: $(originalForm).attr('action'),
                    data: new FormData(originalForm),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false
                })
                .done(response => {
                    $(modal).modal('hide');
                    if (response.status = 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 3000
                        })
                    }
                    $(button).prop('disabled', false);
                    $('#spinner-border').hide();
                    table.ajax.reload();
                })
                .fail(errors => {
                    $('#spinner-border').hide();
                    $(button).prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Opps! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: true,
                    });
                    if (errors.status == 422) {
                        $('#spinner-border').hide()
                        $(button).prop('disabled', false);
                        loopErrors(errors.responseJSON.errors);
                        return;
                    }
                });
        }

        function deleteData(url, name) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true,
            })
            swalWithBootstrapButtons.fire({
                title: 'Apakah anda yakin?',
                text: 'Anda akan menghapus data ' + name +
                    ' !',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Iya, Hapus!',
                cancelButtonText: 'Batalkan',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(url, {
                            '_method': 'delete'
                        })
                        .done(response => {
                            if (response.status = 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                                table.ajax.reload();
                            }
                        })
                        .fail(errors => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Opps! Gagal!',
                                text: errors.responseJSON.message,
                                showConfirmButton: false,
                                timer: 3000
                            })
                            table.ajax.reload();
                        });
                }
            })
        }



        //Select2 Kategori
        $('#categories').select2({
            placeholder: "Pilih kategori",
            allowClear: true,
            closeOnSelect: true,
            theme: 'bootstrap4',
            ajax: {
                url: '{{ route('kategori.search') }}',
                processResults: function(data) {
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.name
                            }
                        })
                    }
                }
            }
        });

        //Select2 unit
        $('#unit').select2({
            placeholder: "Pilih satuan",
            allowClear: true,
            closeOnSelect: true,
            theme: 'bootstrap4',
            ajax: {
                url: '{{ route('satuan.search') }}',
                processResults: function(data) {
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.name
                            }
                        })
                    }
                }
            }
        });
    </script>
@endpush
