function validateRegisterForm(){
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const role = document.getElementById('role').value;

    if (!name || !email || !password || !role){
        alert('Please fill in all fields');
        return false;
    }

    if (password.length < 6){
        alert('Password must be at least 6 characters');
        return false;
    }

    return true;
}

function toggleRoleFields(){
    const role = document.getElementById('role').value;
    const addressField = document.getElementById('address-field');
    const departmentField = document.getElementById('department-field');
    
    if (addressField && departmentField) {
        if (role === 'admin'){
            addressField.style.display = 'none';
            departmentField.style.display = 'block';
        } else {
            addressField.style.display = 'block';
            departmentField.style.display = 'none';
        }
    }
}

function closeAllModals(){
    const modals = document.querySelectorAll('.modal');
    modals.forEach(function(modal){
        modal.style.display = 'none';
    });
}

function openModal(modalId){
    closeAllModals();
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'block';
    }
}

function closeModal(modalId){
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
    }
}

function showDeleteConfirmation(){
    return confirm('Are you sure you want to delete this item?');
}

function showApproveMessage(){
    alert('The reservation has been approved.');
}

function showDeclineMessage(){
    alert('The reservation has been declined.');
}

function showBookConfirmation(){
    alert('Your reservation request has been submitted!');
}

function showUpdateConfirmation(){
    alert('Your reservation has been updated.');
}

window.onload = function(){
    const roleSelect = document.getElementById('role');
    if (roleSelect && roleSelect.value) {
        toggleRoleFields();
    }

    document.querySelectorAll('a[href^="#"]').forEach(function(link){
        link.addEventListener('click', function(e){
            const targetId = this.getAttribute('href').substring(1);
            const target = document.getElementById(targetId);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
};

