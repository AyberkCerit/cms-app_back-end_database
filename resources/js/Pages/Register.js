import axios from "axios";
import Swal from "sweetalert2";

export class Register {
    constructor() {
        this.load();
    };

    load() {
        this.events();
    }

    events() {
        let self = this;
        $('body').on('click', '.registerBtn', function () {
            self.register();
        })
    }

    async register() {
        $('.registerBtn').prop('disabled', true).text('Signing up...');
        
        try {
            const { data } = await axios.post("/api/register", {
                name: $(".name").val(),
                email: $(".email").val(),
                password: $(".password").val()
            });

            if (data && data.status) {
                Swal.fire({ title: 'Success', text: data.message, icon: 'success' }).then(() => {
                    window.location.href = "/dashboard";
                });
            } else {
                Swal.fire('Error', data.message, 'error');
                $('.registerBtn').prop('disabled', false).text('Sign up');
            }
        } catch (error) {
            Swal.fire('Error', 'Something went wrong.', 'error');
            $('.registerBtn').prop('disabled', false).text('Sign up');
        }
    }
}
