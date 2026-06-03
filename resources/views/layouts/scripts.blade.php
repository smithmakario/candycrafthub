<script>
        // Micro-interactions for floating background elements
        document.addEventListener('mousemove', (e) => {
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;

            document.getElementById('float-1').style.transform = `translate(${x * 50}px, ${y * 50}px) rotate(${x * 20}deg)`;
            document.getElementById('float-2').style.transform = `translate(${-x * 30}px, ${-y * 30}px) rotate(${-y * 15}deg)`;
            document.getElementById('float-3').style.transform = `translate(${x * 10}px, ${-y * 40}px) scale(${1 + x * 0.1})`;
        });

        // Simple animation loop for the "In Production" progress bar
        const progressBar = document.querySelector('.bg-primary.h-full');
        if(progressBar) {
            setInterval(() => {
                const currentWidth = parseInt(progressBar.style.width) || 75;
                if(currentWidth < 98) {
                    progressBar.style.width = (currentWidth + 0.1) + '%';
                }
            }, 1000);
        }
    </script>
