import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {

    /*
    |--------------------------------------------------------------------------
    | Auto hide alerts
    |--------------------------------------------------------------------------
    */

    const alerts = document.querySelectorAll('.alert');

    alerts.forEach((alert) => {

        setTimeout(() => {

            alert.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-5px)';

            setTimeout(() => {
                alert.remove();
            }, 300);

        }, 5000);

    });


    /*
    |--------------------------------------------------------------------------
    | Confirm voting
    |--------------------------------------------------------------------------
    */

    const voteForms = document.querySelectorAll(
        'form[action*="/vote/"]'
    );

    voteForms.forEach((form) => {

        form.addEventListener('submit', (event) => {

            const confirmed = confirm(
                'Sudah yakin dengan pilihan Anda? Anda hanya bisa memilih satu kali.'
            );

            if (!confirmed) {
                event.preventDefault();
            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Mobile sidebar
    |--------------------------------------------------------------------------
    */

    const sidebar = document.getElementById('sidebar');
    const mobileButton = document.getElementById('mobileMenuButton');

    if (sidebar && mobileButton) {

        mobileButton.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });

        document.addEventListener('click', (event) => {

            if (
                window.innerWidth <= 1024 &&
                sidebar.classList.contains('open') &&
                !sidebar.contains(event.target) &&
                !mobileButton.contains(event.target)
            ) {
                sidebar.classList.remove('open');
            }

        });

    }

});