import axios from "axios";
import Swal from "sweetalert2";

export class Languages {
    constructor() {
        this.load();
    };

    load() {
        this.events();
    }

    events() {
        let self = this;

        $('body').on('change', '.toggle-status', function () {
            let id = $(this).data('id');
            self.toggleStatus(id);
        });

        $('body').on('submit', '#addLanguageForm', function (e) {
            e.preventDefault();
            self.saveLanguage($(this));
        });

        $('body').on('click', '.deleteLanguageBtn', function (e) {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Emin misiniz?',
                text: "Bu dili silmek istediğinize emin misiniz?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, Sil!',
                cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.isConfirmed) {
                    self.deleteLanguage(id);
                }
            })
        });
    }

    toggleStatus(id) {
        axios.post('/api/languages/toggleStatus', { id: id })
            .then(res => {
                if (res.data.status) {
                    const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
                    Toast.fire({ icon: 'success', title: res.data.message });
                    setTimeout(() => { window.location.reload(); }, 1000);
                } else {
                    Swal.fire("Hata", res.data.message, "error");
                }
            })
            .catch(err => {
                console.error(err);
            });
    }

    saveLanguage(form) {
        let formData = form.serialize();
        axios.post('/api/languages/saveLanguage', formData)
            .then(res => {
                if (res.data.status) {
                    const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
                    Toast.fire({ icon: 'success', title: res.data.message });
                    setTimeout(() => { window.location.reload(); }, 1000);
                } else {
                    Swal.fire("Hata", res.data.message, "error");
                }
            })
            .catch(err => {
                console.error(err);
            });
    }

    deleteLanguage(id) {
        axios.post('/api/languages/deleteLanguage', { id: id })
            .then(res => {
                if (res.data.status) {
                    Swal.fire("Başarılı", res.data.message, "success");
                    setTimeout(() => { window.location.reload(); }, 1000);
                } else {
                    Swal.fire("Hata", res.data.message, "error");
                }
            })
            .catch(err => {
                console.error(err);
            });
    }
}
