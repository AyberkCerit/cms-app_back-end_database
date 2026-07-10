import axios from "axios";
import Swal from "sweetalert2";


export class Users {
    constructor() {
        this.load();

    };

    load() {
        this.events();
        this.getData();

        // alert("sa");
        // $("#usersTable").dataTable();





    }

    events() {
        let self = this;
        $('body').on('click', '.saveUserBtn', function () {
            self.saveUser();

        });

        $('body').on('click', '.deleteUserBtn', function () {
            let id = $(this).data('id');
            self.deleteUser(id);
        });
        $('body').on('click', '.editUserBtn', function () {
            const id = $(".selected").attr("data-id");
            if (id == undefined) {
                const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
                Toast.fire({ icon: 'error', title: 'Lütfen bir kullanıcı seçin.' });
            }
            else {
                window.location.href = "/users/edit/" + id;
            }

        });
        $('body').on('click', '.deleteUserBtn', function () {
            const id = $(".selected").attr("data-id");
            if (id == undefined) {
                const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
                Toast.fire({ icon: 'error', title: 'Lütfen bir kullanıcı seçin.' });
            }
            else {
                self.deleteUser(id);
            }

        });

        // Real-time password matching
        $('body').on('input', '.password, .password_rep', function() {
            let pass = $('.password').val();
            let rep = $('.password_rep').val();

            if (rep.length > 0) {
                if (pass === rep) {
                    $('.password_rep').removeClass('is-invalid').addClass('is-valid');
                } else {
                    $('.password_rep').removeClass('is-valid').addClass('is-invalid');
                }
            } else {
                $('.password_rep').removeClass('is-valid is-invalid');
            }
        });

    }

    getData() {
        let self = this;
        $('#usersTable').DataTable({
            processing: true,
            serverSide: true,
            select: true,
            ajax: {
                url: '/api/users/getData',
                type: 'POST',
                // data: function (d) {
                //     d._token = '{{ csrf_token() }}';
                // }
            },
            columns: [
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'status_name', name: 'status_name' },
                { data: 'action', name: 'action' }
            ],
        });
    }
    async saveUser() {
        const userData = {
            name_surname: $(".name_surname").val(),
            email: $(".email").val(),
            phone: $(".phone").val(),
            password: $(".password").val(),
            password_rep: $(".password_rep").val(),
            status: $(".status").val(),
            user_id: $(".user_id").val()

        };

        // UI Feedback: Button Loading
        let btn = $('.saveUserBtn');
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
            const { data } = await axios.post("/api/users/saveUser", userData);
            if (data && data.status) {
                Toast.fire({
                    icon: 'success',
                    title: data.message
                }).then(() => {
                    window.location.href = "/users";
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
    async deleteUser(id) {
        Swal.fire({
            title: 'Emin misiniz?',
            text: "Kullanıcı kaydını silmek istediğinize emin misiniz?",
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
                const { data } = await axios.post("/api/users/deleteUser", { id: id });
                
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });

                if (data && data.status) {
                    Toast.fire({ icon: 'success', title: data.message });
                    $('#usersTable').DataTable().ajax.reload();
                } else {
                    Toast.fire({ icon: 'error', title: data.message });
                }
            }
        });
    }
}