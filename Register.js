document.addEventListener('DOMContentLoaded', () => {
    const registerBtn = document.getElementById('registerBtn');

    if (registerBtn) {
        registerBtn.addEventListener('click', (e) => {
            e.preventDefault();

            const name = document.getElementById('regName').value.trim();
            const id = document.getElementById('regNationalID').value.trim();
            const nationality = document.getElementById('regNationality').value.trim();
            const gender = document.getElementById('regGender').value;
            const phone = document.getElementById('regPhone').value.trim();
            const birthdate = document.getElementById('regBirthdate').value;
            const email = document.getElementById('regEmail').value.trim();
            const pass = document.getElementById('regPassword').value;
            const conf = document.getElementById('regConfirm').value;

            if (!name || !id || !nationality || !gender || !phone || !birthdate || !email || !pass) {
                return alert('❌ Please fill all required fields');
            }
            if (!/^\d{11}$/.test(phone)) {
                return alert('❌ Phone number must be 11 digits');
            }
            if (!/^\d{14}$/.test(id)) {
                return alert('❌ National ID must be 14 digits');
            }
            if (pass.length < 4) {
                return alert('❌ Password too short');
            }
            if (pass !== conf) {
                return alert('❌ Passwords do not match');
            }
            if (!/^\S+@\S+\.\S+$/.test(email)) {
                return alert('❌ Invalid email format');
            }

            document.getElementById('registerForm').submit();
        });
    }
});
