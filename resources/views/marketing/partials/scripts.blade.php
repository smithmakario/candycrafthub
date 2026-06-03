<script>
    document.getElementById('mobile-menu-toggle')?.addEventListener('click', () => {
        alert('Mobile menu coming soon! Please use desktop view for full experience.');
    });

    document.querySelectorAll('.quiz-choice').forEach((button) => {
        button.addEventListener('click', () => {
            button.classList.toggle('quiz-choice-active');
        });
    });

    document.querySelectorAll('.faq-item').forEach((item) => {
        item.addEventListener('click', () => {
            item.classList.toggle('active');
        });
    });
</script>
