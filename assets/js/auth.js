// // auth.js - Famo Academy (Password-based Auth + Bot Link)
// document.addEventListener('DOMContentLoaded', () => {
//     // Elements
//     const loginTab = document.getElementById('loginTab');
//     const registerTab = document.getElementById('registerTab');
//     const loginFormContainer = document.getElementById('loginFormContainer');
//     const registerFormContainer = document.getElementById('registerFormContainer');
//     const botLinkContainer = document.getElementById('botLinkContainer');
//     const messageContainer = document.getElementById('messageContainer');
//     const formMessageTitle = document.getElementById('formMessageTitle');
//     const formMessage = document.getElementById('formMessage');
//     const redirectButton = document.getElementById('redirectButton');
    
//     // Bot link elements
//     const showBotLinkBtn = document.getElementById('showBotLinkBtn');
//     const backToRegisterBtn = document.getElementById('backToRegisterBtn');
//     const botLinkStep1 = document.getElementById('botLinkStep1');
//     const botLinkStep2 = document.getElementById('botLinkStep2');
    
//     // Grade/Field handling
//     const gradeSelect = document.querySelector('#formRegister select[name="grade"]');
//     const fieldContainer = document.getElementById('fieldContainer');
//     const fieldSelect = document.querySelector('#formRegister select[name="field"]');
    
//     // Handle grade change - hide field for grades 7-9
//     if (gradeSelect) {
//         gradeSelect.addEventListener('change', () => {
//             const grade = parseInt(gradeSelect.value);
//             if (grade <= 9) {
//                 fieldContainer.style.display = 'none';
//                 fieldSelect.removeAttribute('required');
//                 fieldSelect.value = '';
//             } else {
//                 fieldContainer.style.display = 'block';
//                 fieldSelect.setAttribute('required', '');
//             }
//         });
//     }

//     // Tab switching
//     loginTab.addEventListener('click', () => switchTab('login'));
//     registerTab.addEventListener('click', () => switchTab('register'));

//     function switchTab(tabName) {
//         const isLogin = tabName === 'login';
//         loginTab.classList.toggle('active', isLogin);
//         registerTab.classList.toggle('active', !isLogin);
//         loginFormContainer.style.display = isLogin ? 'block' : 'none';
//         registerFormContainer.style.display = !isLogin ? 'block' : 'none';
//         botLinkContainer.style.display = 'none';
//         messageContainer.style.display = 'none';
//     }
    
//     // Show bot link form
//     if (showBotLinkBtn) {
//         showBotLinkBtn.addEventListener('click', () => {
//             registerFormContainer.style.display = 'none';
//             botLinkContainer.style.display = 'block';
//             botLinkStep1.style.display = 'block';
//             botLinkStep2.style.display = 'none';
//         });
//     }
    
//     // Back to register
//     if (backToRegisterBtn) {
//         backToRegisterBtn.addEventListener('click', () => {
//             botLinkContainer.style.display = 'none';
//             registerFormContainer.style.display = 'block';
//         });
//     }

//     function showMessage(type, title, message, redirectUrl = null) {
//         messageContainer.className = type;
//         formMessageTitle.textContent = title;
//         formMessage.textContent = message;
        
//         if (redirectUrl) {
//             redirectButton.style.display = 'inline-block';
//             redirectButton.href = redirectUrl;
//         } else {
//             redirectButton.style.display = 'none';
//         }
        
//         loginFormContainer.style.display = 'none';
//         registerFormContainer.style.display = 'none';
//         botLinkContainer.style.display = 'none';
//         messageContainer.style.display = 'block';
//     }

//     function showError(message, container = null) {
//         showMessage('error', 'خطا', message);
//         setTimeout(() => {
//             messageContainer.style.display = 'none';
//             if (container) {
//                 container.style.display = 'block';
//             } else if (loginTab.classList.contains('active')) {
//                 loginFormContainer.style.display = 'block';
//             } else {
//                 registerFormContainer.style.display = 'block';
//             }
//         }, 3000);
//     }

//     async function handleSubmit(form, successCallback = null) {
//         const button = form.querySelector('button[type="submit"]');
//         const originalText = button.innerHTML;
//         button.disabled = true;
//         button.innerHTML = '<i class="fas fa-spinner fa-spin ml-2"></i> صبر کنید...';
        
//         try {
//             const formData = new FormData(form);
//             const response = await fetch('../api/auth.php', { 
//                 method: 'POST', 
//                 body: formData 
//             });

//             if (!response.ok) {
//                 throw new Error('خطای شبکه یا سرور');
//             }

//             const data = await response.json();

//             if (data.status === 'success') {
//                 if (successCallback) {
//                     successCallback(data);
//                 } else {
//                     const redirectUrl = data.redirect || 'dashboard.php';
//                     showMessage('success', data.title || 'موفق', data.message, redirectUrl);
//                     setTimeout(() => window.location.href = redirectUrl, 1500);
//                 }
//             } else {
//                 // Check if user has bot account
//                 if (data.has_bot_account) {
//                     showBotLinkBtn.click(); // Show bot link form
//                 }
//                 throw new Error(data.message || 'خطایی رخ داد');
//             }
//         } catch (error) {
//             const currentContainer = botLinkContainer.style.display === 'block' ? botLinkContainer : null;
//             showError(error.message, currentContainer);
//         } finally {
//             button.disabled = false;
//             button.innerHTML = originalText;
//         }
//     }

//     // Form submissions
//     document.getElementById('formLogin').addEventListener('submit', (e) => {
//         e.preventDefault();
//         handleSubmit(e.target);
//     });

//     document.getElementById('formRegister').addEventListener('submit', (e) => {
//         e.preventDefault();
//         handleSubmit(e.target);
//     });
    
//     // Bot link - Step 1: Send verification code
//     const formBotLink = document.getElementById('formBotLink');
//     if (formBotLink) {
//         formBotLink.addEventListener('submit', async (e) => {
//             e.preventDefault();
//             const button = e.target.querySelector('button[type="submit"]');
//             const originalText = button.innerHTML;
//             button.disabled = true;
//             button.innerHTML = '<i class="fas fa-spinner fa-spin ml-2"></i> در حال ارسال...';
            
//             try {
//                 const formData = new FormData(e.target);
//                 formData.append('action', 'send_verify_code');
                
//                 const response = await fetch('../api/auth.php', {
//                     method: 'POST',
//                     body: formData
//                 });
                
//                 const data = await response.json();
                
//                 if (data.status === 'success') {
//                     // Show step 2
//                     botLinkStep1.style.display = 'none';
//                     botLinkStep2.style.display = 'block';
//                 } else {
//                     throw new Error(data.message || 'خطا در ارسال کد');
//                 }
//             } catch (error) {
//                 showError(error.message, botLinkContainer);
//             } finally {
//                 button.disabled = false;
//                 button.innerHTML = originalText;
//             }
//         });
//     }
    
//     // Bot link - Step 2: Verify code
//     const formVerifyCode = document.getElementById('formVerifyCode');
//     if (formVerifyCode) {
//         formVerifyCode.addEventListener('submit', async (e) => {
//             e.preventDefault();
//             const button = e.target.querySelector('button[type="submit"]');
//             const originalText = button.innerHTML;
//             button.disabled = true;
//             button.innerHTML = '<i class="fas fa-spinner fa-spin ml-2"></i> در حال تایید...';
            
//             try {
//                 const formData = new FormData(e.target);
//                 formData.append('action', 'verify_code');
                
//                 const response = await fetch('../api/auth.php', {
//                     method: 'POST',
//                     body: formData
//                 });
                
//                 const data = await response.json();
                
//                 if (data.status === 'success') {
//                     const redirectUrl = data.redirect || 'dashboard.php';
//                     showMessage('success', data.title || 'موفق', data.message, redirectUrl);
//                     setTimeout(() => window.location.href = redirectUrl, 1500);
//                 } else {
//                     throw new Error(data.message || 'خطا در تایید کد');
//                 }
//             } catch (error) {
//                 showError(error.message, botLinkContainer);
//             } finally {
//                 button.disabled = false;
//                 button.innerHTML = originalText;
//             }
//         });
//     }
// });

// auth.js - Famo Academy Authentication

document.addEventListener('DOMContentLoaded', function() {
    // ===== Tab Switching =====
    const loginTab = document.getElementById('loginTab');
    const registerTab = document.getElementById('registerTab');
    const loginFormContainer = document.getElementById('loginFormContainer');
    const registerFormContainer = document.getElementById('registerFormContainer');
    const botLinkContainer = document.getElementById('botLinkContainer');
    const showBotLinkBtn = document.getElementById('showBotLinkBtn');
    const backToRegisterBtn = document.getElementById('backToRegisterBtn');

    // نمایش تب‌ها
    loginTab?.addEventListener('click', () => switchTab('login'));
    registerTab?.addEventListener('click', () => switchTab('register'));
    showBotLinkBtn?.addEventListener('click', showBotLink);
    backToRegisterBtn?.addEventListener('click', backToRegister);

    function switchTab(tab) {
        if (tab === 'login') {
            loginTab.classList.add('active');
            registerTab.classList.remove('active');
            loginFormContainer.style.display = 'block';
            registerFormContainer.style.display = 'none';
            botLinkContainer.style.display = 'none';
            hideMessage();
        } else {
            registerTab.classList.add('active');
            loginTab.classList.remove('active');
            registerFormContainer.style.display = 'block';
            loginFormContainer.style.display = 'none';
            botLinkContainer.style.display = 'none';
            hideMessage();
        }
    }

    function showBotLink() {
        loginFormContainer.style.display = 'none';
        registerFormContainer.style.display = 'none';
        botLinkContainer.style.display = 'block';
        document.getElementById('botLinkStep1').style.display = 'block';
        document.getElementById('botLinkStep2').style.display = 'none';
        hideMessage();
    }

    function backToRegister() {
        botLinkContainer.style.display = 'none';
        registerFormContainer.style.display = 'block';
    }

    function hideMessage() {
        const msg = document.getElementById('messageContainer');
        if (msg) msg.style.display = 'none';
    }

    // ===== Form Submissions =====

    // فرم ورود
    const formLogin = document.getElementById('formLogin');
    formLogin?.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!validateForm(formLogin)) return;

        const formData = new FormData(formLogin);
        showLoading(loginFormContainer, true);

        try {
            const response = await fetch('auth.php', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            showLoading(loginFormContainer, false);
            
            if (data.status === 'success') {
                showMessage(data.title, data.message, 'success');
                setTimeout(() => {
                    window.location.href = data.redirect || 'index.php';
                }, 1500);
            } else {
                showMessage(data.message, '', 'error');
            }
        } catch (error) {
            showLoading(loginFormContainer, false);
            showMessage('خطا در ارتباط با سرور', '', 'error');
            console.error('Login Error:', error);
        }
    });

    // فرم ثبت‌نام
    const formRegister = document.getElementById('formRegister');
    formRegister?.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!validateForm(formRegister)) return;

        const formData = new FormData(formRegister);
        showLoading(registerFormContainer, true);

        try {
            const response = await fetch('auth.php', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            showLoading(registerFormContainer, false);
            
            if (data.status === 'success') {
                showMessage(data.title, data.message, 'success');
                setTimeout(() => {
                    window.location.href = data.redirect || 'index.php';
                }, 1500);
            } else {
                if (data.has_bot_account) {
                    showBotLinkMessage(data.message);
                } else {
                    showMessage(data.message, '', 'error');
                }
            }
        } catch (error) {
            showLoading(registerFormContainer, false);
            showMessage('خطا در ارتباط با سرور', '', 'error');
            console.error('Register Error:', error);
        }
    });

    // فرم اتصال به ربات - مرحله ۱
    const formBotLink = document.getElementById('formBotLink');
    formBotLink?.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!validateForm(formBotLink)) return;

        const phone = formBotLink.querySelector('input[name="phone"]').value;
        const formData = new FormData();
        formData.append('action', 'check_bot_account');
        formData.append('phone', phone);

        showLoading(botLinkContainer, true);

        try {
            const response = await fetch('auth.php', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            showLoading(botLinkContainer, false);
            
            if (data.status === 'success') {
                if (data.has_bot_account) {
                    await sendVerifyCode(phone);
                } else {
                    showMessage('این شماره در ربات تلگرام ثبت نشده است', '', 'error');
                }
            } else {
                showMessage(data.message, '', 'error');
            }
        } catch (error) {
            showLoading(botLinkContainer, false);
            showMessage('خطا در ارتباط با سرور', '', 'error');
            console.error('Bot Check Error:', error);
        }
    });

    // فرم تایید کد
    const formVerifyCode = document.getElementById('formVerifyCode');
    formVerifyCode?.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!validateForm(formVerifyCode)) return;

        const formData = new FormData(formVerifyCode);
        formData.append('action', 'verify_code');

        showLoading(botLinkContainer, true);

        try {
            const response = await fetch('auth.php', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            showLoading(botLinkContainer, false);
            
            if (data.status === 'success') {
                showMessage(data.title, data.message, 'success');
                setTimeout(() => {
                    window.location.href = data.redirect || 'index.php';
                }, 1500);
            } else {
                showMessage(data.message, '', 'error');
            }
        } catch (error) {
            showLoading(botLinkContainer, false);
            showMessage('خطا در ارتباط با سرور', '', 'error');
            console.error('Verify Error:', error);
        }
    });

    // ===== Helper Functions =====

    async function sendVerifyCode(phone) {
        const formData = new FormData();
        formData.append('action', 'send_verify_code');
        formData.append('phone', phone);

        try {
            const response = await fetch('auth.php', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.status === 'success') {
                document.getElementById('botLinkStep1').style.display = 'none';
                document.getElementById('botLinkStep2').style.display = 'block';
                showMessage(data.message, '', 'success');
            } else {
                showMessage(data.message, '', 'error');
            }
        } catch (error) {
            showMessage('خطا در ارسال کد تایید', '', 'error');
            console.error('Send Code Error:', error);
        }
    }

    function showMessage(title, message, type) {
        const container = document.getElementById('messageContainer');
        const titleEl = document.getElementById('formMessageTitle');
        const messageEl = document.getElementById('formMessage');
        const redirectBtn = document.getElementById('redirectButton');
        
        loginFormContainer.style.display = 'none';
        registerFormContainer.style.display = 'none';
        botLinkContainer.style.display = 'none';
        
        container.style.display = 'block';
        container.className = 'text-center p-5 ' + (type === 'success' ? 'success' : 'error');
        
        titleEl.textContent = title || (type === 'success' ? 'موفق!' : 'خطا!');
        messageEl.textContent = message;
        
        if (type === 'success') {
            redirectBtn.style.display = 'inline-block';
            container.querySelector('.message-icon').innerHTML = 
                '<svg class="icon" style="width: 3rem; height: 3rem; color: #22c55e;" aria-hidden="true"><use href="../assets/icons/sprite.svg#icon-check-circle"/></svg>';
        } else {
            redirectBtn.style.display = 'none';
            container.querySelector('.message-icon').innerHTML = 
                '<svg class="icon" style="width: 3rem; height: 3rem; color: #ef4444;" aria-hidden="true"><use href="../assets/icons/sprite.svg#icon-alert-circle"/></svg>';
        }
    }

    function showBotLinkMessage(message) {
        const container = document.getElementById('messageContainer');
        const titleEl = document.getElementById('formMessageTitle');
        const messageEl = document.getElementById('formMessage');
        const redirectBtn = document.getElementById('redirectButton');
        
        registerFormContainer.style.display = 'none';
        
        container.style.display = 'block';
        container.className = 'text-center p-5 error';
        
        titleEl.textContent = 'حساب ربات یافت شد';
        messageEl.textContent = message;
        redirectBtn.style.display = 'none';
        
        container.querySelector('.message-icon').innerHTML = 
            '<svg class="icon" style="width: 3rem; height: 3rem; color: #0088cc;" aria-hidden="true"><use href="../assets/icons/sprite.svg#icon-telegram"/></svg>';
        
        const botBtn = document.createElement('button');
        botBtn.type = 'button';
        botBtn.className = 'inline-block w-full py-3 rounded-xl bg-[#0088cc] text-white font-semibold text-lg hover:bg-[#0077b3] transition-all duration-300 mt-4';
        botBtn.innerHTML = '<svg class="icon icon--sm inline-block ml-2" aria-hidden="true"><use href="../assets/icons/sprite.svg#icon-telegram"/></svg> اتصال به ربات';
        botBtn.onclick = showBotLink;
        
        messageEl.after(botBtn);
    }

    function showLoading(container, show) {
        const existingLoader = container.querySelector('.loading-overlay');
        
        if (show) {
            if (!existingLoader) {
                const loader = document.createElement('div');
                loader.className = 'loading-overlay absolute inset-0 bg-white/80 flex items-center justify-center z-10';
                loader.innerHTML = '<div class="animate-spin rounded-full h-10 w-10 border-4 border-[#445D84] border-t-transparent"></div>';
                container.appendChild(loader);
            }
        } else {
            if (existingLoader) {
                existingLoader.remove();
            }
        }
    }

    // ===== Grade/Field Logic =====
    const registerGrade = document.getElementById('registerGrade');
    const fieldContainer = document.getElementById('fieldContainer');
    
    registerGrade?.addEventListener('change', function() {
        const grade = parseInt(this.value);
        
        if (grade >= 10) {
            fieldContainer.style.display = 'block';
            document.getElementById('registerField').required = true;
        } else {
            fieldContainer.style.display = 'none';
            document.getElementById('registerField').required = false;
            document.getElementById('registerField').value = 'راهنمایی';
        }
    });

    if (registerGrade) {
        fieldContainer.style.display = 'none';
    }
});