import axios from "axios";
import Swal from "sweetalert2";

export class BlogPosts {
    constructor() {
        this.load();
    };

    load() {
        this.events();
        this.getData();
    }

    events() {
        let self = this;
        $('body').on('click', '.savePostBtn', function () {
            self.savePost();
        });

        $('body').on('click', '.togglePostBtn', function (e) {
            let id = $(this).data('id');
            if (id) {
                self.toggleStatus(id);
            }
        });

        $('body').on('click', '.deletePostBtn', function (e) {
            // Check if it's from the table row button
            let id = $(this).data('id');
            if (id) {
                self.deletePost(id);
            } else {
                // Check if it's from the toolbar button (needs selection)
                const selectedId = $(".selected").attr("data-id");
                if (selectedId == undefined) {
                    const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
                    Toast.fire({ icon: 'error', title: 'Lütfen bir yazı seçin.' });
                }
                else {
                    self.deletePost(selectedId);
                }
            }
        });

        $('body').on('click', '.editPostBtn', function () {
            const id = $(".selected").attr("data-id");
            if (id == undefined) {
                const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
                Toast.fire({ icon: 'error', title: 'Lütfen bir yazı seçin.' });
            }
            else {
                window.location.href = "/admin/blog-posts/edit/" + id;
            }
        });
    }

    getData() {
        let self = this;
        $('#postsTable').DataTable({
            processing: true,
            serverSide: true,
            select: true,
            ajax: {
                url: '/api/blog-posts/getData',
                type: 'POST',
            },
            columns: [
                { data: 'post_title', name: 'post_title' },
                { data: 'category_name', name: 'category_name', orderable: false },
                { data: 'status_name', name: 'status_name', orderable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
        });
    }

    async savePost() {
        let titleData = {};
        $('.title-input').each(function() {
            titleData[$(this).data('lang')] = $(this).val();
        });

        let summaryData = {};
        $('.summary-input').each(function() {
            summaryData[$(this).data('lang')] = $(this).val();
        });

        let contentData = {};
        $('.content-input').each(function() {
            contentData[$(this).data('lang')] = $(this).val();
        });

        const postData = {
            title: JSON.stringify(titleData),
            summary: JSON.stringify(summaryData),
            content: JSON.stringify(contentData),
            category_id: $(".category_id").val(),
            image: $(".image").val(),
            status: $(".status").val(),
            post_id: $(".post_id").val()
        };

        let btn = $('.savePostBtn');
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
            const { data } = await axios.post("/api/blog-posts/savePost", postData);
            if (data && data.status) {
                Toast.fire({
                    icon: 'success',
                    title: data.message
                }).then(() => {
                    window.location.href = "/admin/blog-posts";
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

    async toggleStatus(id) {
        try {
            const { data } = await axios.post("/api/blog-posts/toggleStatus", { id: id });
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

            if (data && data.status) {
                Toast.fire({ icon: 'success', title: data.message });
                $('#postsTable').DataTable().ajax.reload(null, false);
            } else {
                Toast.fire({ icon: 'error', title: data.message });
            }
        } catch (error) {
            Swal.fire("Hata", "Durum güncellenirken bir hata oluştu.", "error");
        }
    }

    async deletePost(id) {
        Swal.fire({
            title: 'Emin misiniz?',
            text: "Yazıyı silmek istediğinize emin misiniz?",
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
                const { data } = await axios.post("/api/blog-posts/deletePost", { id: id });
                
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });

                if (data && data.status) {
                    Toast.fire({ icon: 'success', title: data.message });
                    $('#postsTable').DataTable().ajax.reload();
                } else {
                    Toast.fire({ icon: 'error', title: data.message });
                }
            }
        });
    }
}
