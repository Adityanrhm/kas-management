<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: radial-gradient(ellipse at center, #1a1a1a 0%, #0a0a0a 70%, #000000 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Georgia', 'Times New Roman', serif;
            overflow: hidden;
            position: relative;
        }

        /* Elegant red ambient glow */
        .ambient-glow {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 80%, rgba(220, 20, 60, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(139, 0, 0, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255, 69, 0, 0.05) 0%, transparent 70%);
            animation: ambientPulse 6s ease-in-out infinite alternate;
            z-index: 1;
        }

        @keyframes ambientPulse {
            0% {
                opacity: 0.3;
            }

            100% {
                opacity: 0.6;
            }
        }

        /* Floating white particles */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 2;
        }

        .particle {
            position: absolute;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.3) 40%, transparent 70%);
            border-radius: 50%;
            animation: elegantFloat 8s ease-in-out infinite;
            filter: blur(0.5px);
        }

        .particle:nth-child(1) {
            width: 3px;
            height: 3px;
            left: 15%;
            animation-delay: 0s;
        }

        .particle:nth-child(2) {
            width: 2px;
            height: 2px;
            left: 25%;
            animation-delay: 2s;
        }

        .particle:nth-child(3) {
            width: 4px;
            height: 4px;
            left: 35%;
            animation-delay: 4s;
        }

        .particle:nth-child(4) {
            width: 2px;
            height: 2px;
            left: 45%;
            animation-delay: 1s;
        }

        .particle:nth-child(5) {
            width: 3px;
            height: 3px;
            left: 55%;
            animation-delay: 3s;
        }

        .particle:nth-child(6) {
            width: 2px;
            height: 2px;
            left: 65%;
            animation-delay: 1s;
        }

        .particle:nth-child(7) {
            width: 4px;
            height: 4px;
            left: 75%;
            animation-delay: 0.5s;
        }

        .particle:nth-child(8) {
            width: 3px;
            height: 3px;
            left: 85%;
            animation-delay: 3.5s;
        }

        @keyframes elegantFloat {

            0%,
            100% {
                transform: translateY(100vh) translateX(0px) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 0.7;
            }

            50% {
                transform: translateY(50vh) translateX(20px) rotate(180deg);
                opacity: 1;
            }

            90% {
                opacity: 0.7;
            }

            100% {
                transform: translateY(-10vh) translateX(-10px) rotate(360deg);
                opacity: 0;
            }
        }

        /* Main container */
        .container {
            text-align: center;
            z-index: 10;
            position: relative;
            padding: 3rem 2rem;
        }

        /* Elegant glowing 404 */
        .error-code {
            font-size: 10rem;
            font-weight: 300;
            color: #ffffff;
            margin-bottom: 2rem;
            position: relative;
            letter-spacing: 0.1em;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.5),
                0 0 40px rgba(255, 255, 255, 0.3),
                0 0 60px rgba(255, 255, 255, 0.2);
            animation: elegantGlow 3s ease-in-out infinite alternate;
        }

        .error-code::before {
            content: '404';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            color: rgba(220, 20, 60, 0.3);
            filter: blur(15px);
            z-index: -1;
            animation: redGlow 4s ease-in-out infinite alternate;
        }

        @keyframes elegantGlow {
            0% {
                text-shadow: 0 0 20px rgba(255, 255, 255, 0.5),
                    0 0 40px rgba(255, 255, 255, 0.3),
                    0 0 60px rgba(255, 255, 255, 0.2);
            }

            100% {
                text-shadow: 0 0 30px rgba(255, 255, 255, 0.8),
                    0 0 50px rgba(255, 255, 255, 0.5),
                    0 0 80px rgba(255, 255, 255, 0.3);
            }
        }

        @keyframes redGlow {
            0% {
                color: rgba(220, 20, 60, 0.2);
                transform: scale(1);
            }

            100% {
                color: rgba(220, 20, 60, 0.4);
                transform: scale(1.02);
            }
        }

        /* Elegant divider */
        .divider {
            width: 200px;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
            margin: 0 auto 2rem auto;
            position: relative;
            animation: fadeInUp 0.4s ease-out 0.4s both;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 6px;
            height: 6px;
            background: #ffffff;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
        }

        /* Title and description */
        .error-title {
            font-size: 2rem;
            color: #ffffff;
            margin-bottom: 1.5rem;
            font-weight: 300;
            letter-spacing: 0.05em;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
            animation: fadeInUp 0.4s ease-out 0.4s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Elegant button */
        .back-button {
            display: inline-block;
            padding: 16px 48px;
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            text-decoration: none;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 4px;
            font-weight: 300;
            font-size: 1rem;
            letter-spacing: 0.1em;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            animation: fadeInUp 0.5s ease-out 0.5s both;
            backdrop-filter: blur(10px);
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        .back-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .back-button::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(220, 20, 60, 0.1);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .back-button:hover {
            transform: translateY(-2px);
            border-color: rgba(255, 255, 255, 0.6);
            box-shadow: 0 8px 25px rgba(220, 20, 60, 0.2),
                0 0 20px rgba(255, 255, 255, 0.1);
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.5);
        }

        .back-button:hover::before {
            left: 100%;
        }

        .back-button:hover::after {
            opacity: 1;
        }

        /* Elegant corner decorations */
        .corner-decoration {
            position: absolute;
            width: 80px;
            height: 80px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 5;
        }

        .corner-decoration.top-left {
            top: 30px;
            left: 30px;
            border-right: none;
            border-bottom: none;
        }

        .corner-decoration.top-right {
            top: 30px;
            right: 30px;
            border-left: none;
            border-bottom: none;
        }

        .corner-decoration.bottom-left {
            bottom: 30px;
            left: 30px;
            border-right: none;
            border-top: none;
        }

        .corner-decoration.bottom-right {
            bottom: 30px;
            right: 30px;
            border-left: none;
            border-top: none;
        }

        .corner-decoration::before {
            content: '';
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(220, 20, 60, 0.6);
            border-radius: 50%;
            box-shadow: 0 0 8px rgba(220, 20, 60, 0.4);
        }

        .corner-decoration.top-left::before {
            top: -2px;
            left: -2px;
        }

        .corner-decoration.top-right::before {
            top: -2px;
            right: -2px;
        }

        .corner-decoration.bottom-left::before {
            bottom: -2px;
            left: -2px;
        }

        .corner-decoration.bottom-right::before {
            bottom: -2px;
            right: -2px;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .error-code {
                font-size: 7rem;
            }

            .error-title {
                font-size: 1.8rem;
            }

            .back-button {
                padding: 14px 36px;
                font-size: 0.9rem;
            }

            .corner-decoration {
                width: 60px;
                height: 60px;
            }
        }

        @media (max-width: 480px) {
            .error-code {
                font-size: 5rem;
            }

            .error-title {
                font-size: 1.5rem;
            }

            .corner-decoration {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- Ambient red glow -->
    <div class="ambient-glow"></div>

    <!-- Floating white particles -->
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <!-- Corner decorations -->
    <div class="corner-decoration top-left"></div>
    <div class="corner-decoration top-right"></div>
    <div class="corner-decoration bottom-left"></div>
    <div class="corner-decoration bottom-right"></div>

    <!-- Main content -->
    <div class="container">
        <div class="error-code">@yield('code', '404')</div>
        <div class="divider"></div>
        <h1 class="error-title">@yield('title', 'Halaman Tidak Ditemukan')</h1>
        <a href="@yield('url', '/')" class="back-button">@yield('button', 'Kembali ke Beranda')</a>
    </div>

    <script>
        // Elegant cursor trail effect
        document.addEventListener('mousemove', (e) => {
            const trail = document.createElement('div');
            trail.style.position = 'absolute';
            trail.style.left = e.clientX + 'px';
            trail.style.top = e.clientY + 'px';
            trail.style.width = '2px';
            trail.style.height = '2px';
            trail.style.background = 'radial-gradient(circle, rgba(255, 255, 255, 0.8) 0%, transparent 70%)';
            trail.style.borderRadius = '50%';
            trail.style.pointerEvents = 'none';
            trail.style.zIndex = '999';
            trail.style.animation = 'trailFade 2s ease-out forwards';

            document.body.appendChild(trail);

            setTimeout(() => {
                trail.remove();
            }, 2000);
        });

        // Add trail fade animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes trailFade {
                0% { 
                    opacity: 1; 
                    transform: scale(1); 
                    filter: blur(0px);
                }
                100% { 
                    opacity: 0; 
                    transform: scale(3); 
                    filter: blur(2px);
                }
            }
        `;
        document.head.appendChild(style);

        // Random particle generation
        setInterval(() => {
            if (Math.random() > 0.95) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.width = (Math.random() * 3 + 2) + 'px';
                particle.style.height = particle.style.width;
                particle.style.animationDuration = (Math.random() * 4 + 6) + 's';

                document.querySelector('.particles').appendChild(particle);

                setTimeout(() => {
                    particle.remove();
                }, 10000);
            }
        }, 500);
    </script>
</body>

</html>
