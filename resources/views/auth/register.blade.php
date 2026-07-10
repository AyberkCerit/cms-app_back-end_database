@extends('layouts.auth.auth')

@section('auth_content')
<div class="container d-flex flex-column">
    <div class="row vh-100">
        <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
            <div class="d-table-cell align-middle">

                <div class="text-center mt-4">
                    <h1 class="h2">Create an Account</h1>
                    <p class="lead">
                        Sign up to continue
                    </p>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="m-sm-3">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input class="form-control form-control-lg name" type="text" name="name" placeholder="Enter your full name" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input class="form-control form-control-lg email" type="email" name="email" placeholder="Enter your email" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input class="form-control form-control-lg password" type="password" name="password" placeholder="Enter your password" />
                                    <ul class="list-unstyled mt-2 small" id="password-rules">
                                        <li id="rule-length" class="text-danger">❌ At least 8 characters</li>
                                        <li id="rule-upper" class="text-danger">❌ At least 1 uppercase letter</li>
                                        <li id="rule-lower" class="text-danger">❌ At least 1 lowercase letter</li>
                                        <li id="rule-number" class="text-danger">❌ At least 1 number</li>
                                        <li id="rule-symbol" class="text-danger">❌ At least 1 symbol</li>
                                    </ul>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Repeat Password</label>
                                    <input class="form-control form-control-lg password_confirmation" type="password" name="password_confirmation" placeholder="Repeat your password" />
                                </div>
                                <div class="d-grid gap-2 mt-3">
                                    <button type="button" class="btn btn-lg btn-primary registerBtn">Sign up</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="text-center mb-3">
                    Already have an account? <a href="{{ route('login') }}">Sign in</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var registerBtn = document.querySelector('.registerBtn');
        var passwordInput = document.querySelector('.password');

        if (passwordInput) {
            passwordInput.addEventListener('input', function(e) {
                const val = e.target.value;
                
                const checkRule = (id, condition) => {
                    const el = document.getElementById(id);
                    if (condition) {
                        if (el.classList.contains('text-danger')) {
                            el.classList.remove('text-danger');
                            el.classList.add('text-success');
                            el.textContent = el.textContent.replace('❌', '✅');
                        }
                    } else {
                        if (el.classList.contains('text-success')) {
                            el.classList.remove('text-success');
                            el.classList.add('text-danger');
                            el.textContent = el.textContent.replace('✅', '❌');
                        }
                    }
                };

                checkRule('rule-length', val.length >= 8);
                checkRule('rule-upper', /[A-Z]/.test(val));
                checkRule('rule-lower', /[a-z]/.test(val));
                checkRule('rule-number', /[0-9]/.test(val));
                checkRule('rule-symbol', /[\\W_]/.test(val));
            });
        }

        if (registerBtn) {
            registerBtn.addEventListener('click', async function() {
                registerBtn.disabled = true;
                registerBtn.textContent = 'Signing up...';
                
                try {
                    const response = await fetch('/api/register', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({
                            name: document.querySelector('.name').value,
                            email: document.querySelector('.email').value,
                            password: document.querySelector('.password').value,
                            password_confirmation: document.querySelector('.password_confirmation').value
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (data && data.status) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({ title: 'Success', text: data.message, icon: 'success' }).then(() => {
                                window.location.href = "/dashboard";
                            });
                        } else {
                            alert(data.message);
                            window.location.href = "/dashboard";
                        }
                    } else {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire('Error', data.message || 'Error occurred', 'error');
                        } else {
                            alert(data.message || 'Error occurred');
                        }
                        registerBtn.disabled = false;
                        registerBtn.textContent = 'Sign up';
                    }
                } catch (error) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Error', 'Something went wrong.', 'error');
                    } else {
                        alert('Something went wrong.');
                    }
                    registerBtn.disabled = false;
                    registerBtn.textContent = 'Sign up';
                }
            });
        }
    });
</script>
@endsection
