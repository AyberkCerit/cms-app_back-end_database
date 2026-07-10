import axios from "axios";
import Swal from "sweetalert2";

export class BlogCategories {
    constructor() {
        this.load();
    };

    load() {
        this.events();
        this.getData();
    }

    events() {
        let self = this;
        $('body').on('click', '.saveCategoryBtn', function () {
            self.saveCategory();
        });

        $('body').on('click', '.deleteCategoryBtn', function () {
            let id = $(this).data('id');
            self.deleteCategory(id);
        });

        $('body').on('click', '.editCategoryBtn', function () {
            const id = $(".selected").attr("data-id");
            if (id == undefined) {
                const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
                Toast.fire({ icon: 'error', title: 'Lütfen bir kategori seçin.' });
            }
            else {
                window.location.href = "/admin/blog-categories/edit/" + id;
            }
        });

        $('body').on('click', '.deleteCategoryBtn', function () {
            const id = $(".selected").attr("data-id");
            if (id == undefined) {
                const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
                Toast.fire({ icon: 'error', title: 'Lütfen bir kategori seçin.' });
            }
            else {
                self.deleteCategory(id);
            }
        });
    }

    getData() {
        let self = this;
        $('#categoriesTable').DataTable({
            processing: true,
            serverSide: true,
            select: true,
            ajax: {
                url: '/api/blog-categories/getData',
                type: 'POST',
            },
            columns: [
                { data: 'category_name', name: 'category_name' },
                { data: 'slug', name: 'slug' },
                { data: 'status_name', name: 'status_name' },
                { data: 'action', name: 'action' }
            ],
        });
    }

    async saveCategory() {
        let nameData = {};
        $('.name-input').each(function() {
            let lang = $(this).data('lang');
            nameData[lang] = $(this).val();
        });

        const categoryData = {
            name: JSON.stringify(nameData),
            status: $(".status").val(),
            category_id: $(".category_id").val()
        };

        let btn = $('.saveCategoryBtn');
        let spinner = $('#saveSpinner');
        btn.prop('disabled', true);
        spinner.removeClass('d-none');

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        try {
            const { data } = await axios.post("/api/blog-categories/saveCategory", categoryData);
            if (data && data.status) {
                Toast.fire({
                    icon: 'success',
                    title: data.message
                }).then(() => {
                    window.location.href = "/admin/blog-categories";
                });
            }
            else {
                Toast.fire({ icon: 'error', title: data.message });
                btn.prop('disabled', false);
                spinner.addClass('d-none');
            }
        } catch (error) {
            Toast.fire({ icon: 'error', title: 'Sunucu ile iletişim kurulamadı.' });
            btn.prop('disabled', false);
            spinner.addClass('d-none');
        }
    }

    async deleteCategory(id) {
        Swal.fire({
            title: 'Emin misiniz?',
            text: "Kategoriyi silmek istediğinize emin misiniz?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Evet, Sil!',
            cancelButtonText: 'İptal',
            customClass: {
                backdrop: 'swal2-backdrop-blur'
            }
        }).then(async (result) => {
            if (result.isConfirmed) {
                const { data } = await axios.post("/api/blog-categories/deleteCategory", { id: id });
                
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });

                if (data && data.status) {
                    Toast.fire({ icon: 'success', title: data.message });
                    $('#categoriesTable').DataTable().ajax.reload();
                } else {
                    Toast.fire({ icon: 'error', title: data.message });
                }
            }
        });
    }
}
