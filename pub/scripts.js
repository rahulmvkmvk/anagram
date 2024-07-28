document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('titleForm');

    form.addEventListener('submit', (e) => {
        const titleInput = document.getElementById('title').value;

        // Basic client-side validation for special characters and length
        const regex = /^[a-zA-Z0-9 ._]{1,50}$/;
        if (!regex.test(titleInput)) {
            e.preventDefault();
            alert('Title can only contain letters, numbers, spaces and must be 30 characters or less.');
        }
    });
});
