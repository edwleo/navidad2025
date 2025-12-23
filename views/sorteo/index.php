<?php
session_start();

if (!isset($_SESSION['acceso']) || !$_SESSION['acceso']){
  header("Location: ../../");
}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sorteo Navideño</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Rouge+Script&display=swap"
      rel="stylesheet"
    />

    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        font-family: "Arial", sans-serif;
        background: linear-gradient(135deg, #1a472a 0%, #0d2818 100%);
        min-height: 100vh;
        overflow-x: hidden;
        position: relative;
      }

      /* Navbar navideño */
      .navbar {
        background: linear-gradient(
          90deg,
          #c41e3a 0%,
          #165b33 50%,
          #c41e3a 100%
        );
        padding: 20px;
        display: flex;
        justify-content: space-around;
        align-items: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        position: relative;
        overflow: hidden;
        z-index: 100;
      }

      .navbar::before {
        content: "❄️ ⛄ 🎄 ⭐ 🎁 🔔 ❄️ ⛄ 🎄 ⭐ 🎁 🔔";
        position: absolute;
        font-size: 30px;
        animation: snowScroll 20s linear infinite;
        white-space: nowrap;
      }

      @keyframes snowScroll {
        0% {
          transform: translateX(100%);
        }
        100% {
          transform: translateX(-100%);
        }
      }

      .decoration {
        font-size: 50px;
        animation: float 3s ease-in-out infinite;
        z-index: 1;
      }

      .decoration:nth-child(2) {
        animation-delay: 0.5s;
      }
      .decoration:nth-child(3) {
        animation-delay: 1s;
      }
      .decoration:nth-child(4) {
        animation-delay: 1.5s;
      }
      .decoration:nth-child(5) {
        animation-delay: 2s;
      }

      @keyframes float {
        0%,
        100% {
          transform: translateY(0px) rotate(0deg);
        }
        50% {
          transform: translateY(-20px) rotate(10deg);
        }
      }

      /* Contenedor principal */
      .main-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 50px 20px;
        gap: 50px;
        flex-wrap: wrap;
        position: relative;
        z-index: 10;
      }

      /* Máquina tragamonedas */
      .slot-machine {
        background: linear-gradient(145deg, #8b0000, #dc143c);
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        border: 5px solid gold;
      }

      .slots-container {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
      }

      .slot {
        width: 80px;
        height: 120px;
        background: #fff;
        border: 4px solid #165b33;
        border-radius: 10px;
        overflow: hidden;
        position: relative;
      }

      .slot-numbers {
        position: absolute;
        width: 100%;
        transition: transform 0.1s linear;
      }

      .slot-number {
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 60px;
        font-weight: bold;
        color: #c41e3a;
      }

      .spin-button {
        width: 100%;
        padding: 20px;
        font-size: 24px;
        font-weight: bold;
        background: linear-gradient(145deg, #ffd700, #ffed4e);
        border: none;
        border-radius: 10px;
        cursor: pointer;
        color: #8b0000;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        transition: transform 0.2s;
      }

      .spin-button:hover {
        transform: scale(1.05);
      }

      .spin-button:active {
        transform: scale(0.95);
      }

      /* Panel de ganador */
      .winner-panel {
        background: linear-gradient(145deg, #fff, #f0f0f0);
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        border: 5px solid gold;
        min-width: 350px;
        text-align: center;
      }

      .winner-title {
        font-size: 28px;
        color: #c41e3a;
        margin-bottom: 20px;
        font-weight: bold;
      }

      .winner-name {
        font-size: 32px;
        color: #165b33;
        font-weight: bold;
        min-height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: #fffacd;
        border-radius: 10px;
        border: 3px dashed #c41e3a;
      }

      /* Premios */
      .prizes-container {
        display: flex;
        justify-content: center;
        gap: 30px;
        padding: 40px 20px;
        flex-wrap: wrap;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        margin: 0 20px;
        position: relative;
        z-index: 10;
      }

      .prize {
        background: linear-gradient(145deg, #fff, #f8f8f8);
        padding: 25px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        border: 3px solid gold;
        min-width: 150px;
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
        position: relative;
      }

      .prize:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 25px rgba(255, 215, 0, 0.6);
      }

      .prize.selected {
        transform: scale(1.1);
        box-shadow: 0 0 40px rgba(255, 215, 0, 0.9);
        border: 5px solid #ffd700;
        background: linear-gradient(145deg, #fffacd, #fff8dc);
      }

      .prize.selected::after {
        content: "✓";
        position: absolute;
        top: -15px;
        right: -15px;
        background: #ffd700;
        color: #8b0000;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: bold;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
      }

      .prize-icon {
        font-size: 60px;
        margin-bottom: 10px;
      }

      .prize-name {
        font-size: 14px;
        font-weight: bold;
        color: #165b33;
        margin-bottom: 8px;
      }

      .prize-quantity {
        font-size: 20px;
        font-weight: bold;
        color: #c41e3a;
        background: #fffacd;
        padding: 5px 15px;
        border-radius: 20px;
      }

      /* Overlay de premio seleccionado */
      .prize-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 0;
        pointer-events: none;
      }

      .prize-overlay.active {
        display: flex;
      }

      .prize-background {
        font-size: 400px;
        opacity: 0.8;
        color: #ffd700;
        text-shadow: 0 0 100px rgba(255, 215, 0, 0.3);
      }

      /* Canvas para confetti */
      #confetti-canvas {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 999;
      }

      .title {
        text-align: center;
        font-size: 82px;
        font-family: "Rouge Script", cursive;
        color: #ffd700;
        margin: 0px 0;
        text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7),
          0 0 25px rgba(255, 215, 0, 0.5);
        font-weight: bold;
        letter-spacing: 3px;
        position: relative;
        z-index: 10;
      }
    </style>
  </head>
  <body>
    <!-- Canvas para confetti -->
    <canvas id="confetti-canvas"></canvas>

    <!-- Overlay de premio seleccionado -->
    <div class="prize-overlay" id="prizeOverlay">
      <div class="prize-background" id="prizeBackground"></div>
    </div>

    <!-- Navbar navideño -->
    <div class="navbar">
      <span class="decoration">🎄</span>
      <span class="decoration">⭐</span>
      <span class="decoration">🎁</span>
      <span class="decoration">🔔</span>
      <span class="decoration">⛄</span>
    </div>

    <h1 class="title">🎅 Sorteo Navideño 2025 🎅</h1>

    <!-- Contenedor principal -->
    <div class="main-container">
      <!-- Tragamonedas -->
      <div class="slot-machine">
        <div class="slots-container">
          <div class="slot" id="slot1">
            <div class="slot-numbers"></div>
          </div>
          <div class="slot" id="slot2">
            <div class="slot-numbers"></div>
          </div>
          <div class="slot" id="slot3">
            <div class="slot-numbers"></div>
          </div>
          <div class="slot" id="slot4">
            <div class="slot-numbers"></div>
          </div>
        </div>
        <button class="spin-button" onclick="spin()">🎰 SORTEAR 🎰</button>
      </div>

      <!-- Panel de ganador -->
      <div class="winner-panel">
        <div class="winner-title">🏆 GANADOR 🏆</div>
        <div class="winner-name" id="winnerName">Presiona para sortear</div>
      </div>
    </div>

    <!-- Premios -->
    <div class="prizes-container">
      <div class="prize" onclick="selectPrize(this, '🧺', 'CANASTA NAVIDEÑA')">
        <div class="prize-icon">🧺</div>
        <div class="prize-name">CANASTA<br />NAVIDEÑA</div>
        <div class="prize-quantity">x5</div>
      </div>
      <div class="prize" onclick="selectPrize(this, '🍲', 'OLLA ARROCERA')">
        <div class="prize-icon">🍲</div>
        <div class="prize-name">OLLA<br />ARROCERA</div>
        <div class="prize-quantity">x3</div>
      </div>
      <div
        class="prize"
        onclick="selectPrize(this, '🖥️', 'MONITOR COMPUTADORA')"
      >
        <div class="prize-icon">🖥️</div>
        <div class="prize-name">MONITOR<br />COMPUTADORA</div>
        <div class="prize-quantity">x2</div>
      </div>
      <div class="prize" onclick="selectPrize(this, '🔊', 'PARLANTE GRANDE')">
        <div class="prize-icon">🔊</div>
        <div class="prize-name">PARLANTE<br />GRANDE</div>
        <div class="prize-quantity">x2</div>
      </div>
      <div class="prize" onclick="selectPrize(this, '🎂', 'PANETÓN')">
        <div class="prize-icon">🎂</div>
        <div class="prize-name">PANETÓN</div>
        <div class="prize-quantity">x10</div>
      </div>
    </div>

    <script>
      // Sonidos (usando Web Audio API para generar sonidos)
      const audioContext = new (window.AudioContext ||
        window.webkitAudioContext)();

      function playSpinSound() {
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();

        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);

        oscillator.frequency.setValueAtTime(200, audioContext.currentTime);
        oscillator.frequency.exponentialRampToValueAtTime(
          800,
          audioContext.currentTime + 0.1
        );

        gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(
          0.01,
          audioContext.currentTime + 0.1
        );

        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + 0.1);
      }

      function playWinSound() {
        const notes = [523.25, 659.25, 783.99, 1046.5]; // C, E, G, C (octava superior)
        notes.forEach((freq, index) => {
          const oscillator = audioContext.createOscillator();
          const gainNode = audioContext.createGain();

          oscillator.connect(gainNode);
          gainNode.connect(audioContext.destination);

          oscillator.frequency.setValueAtTime(freq, audioContext.currentTime);
          gainNode.gain.setValueAtTime(
            0.2,
            audioContext.currentTime + index * 0.1
          );
          gainNode.gain.exponentialRampToValueAtTime(
            0.01,
            audioContext.currentTime + index * 0.1 + 0.3
          );

          oscillator.start(audioContext.currentTime + index * 0.1);
          oscillator.stop(audioContext.currentTime + index * 0.1 + 0.3);
        });
      }

      // Confetti
      function createConfetti() {
        const canvas = document.getElementById("confetti-canvas");
        const ctx = canvas.getContext("2d");
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        const confettiPieces = [];
        const colors = [
          "#ff0000",
          "#00ff00",
          "#0000ff",
          "#ffff00",
          "#ff00ff",
          "#00ffff",
          "#ffd700",
        ];

        for (let i = 0; i < 150; i++) {
          confettiPieces.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height - canvas.height,
            r: Math.random() * 6 + 4,
            d: Math.random() * 10 + 5,
            color: colors[Math.floor(Math.random() * colors.length)],
            tilt: Math.random() * 10 - 10,
            tiltAngle: 0,
            tiltAngleIncremental: Math.random() * 0.07 + 0.05,
          });
        }

        function draw() {
          ctx.clearRect(0, 0, canvas.width, canvas.height);

          confettiPieces.forEach((p, index) => {
            ctx.beginPath();
            ctx.lineWidth = p.r / 2;
            ctx.strokeStyle = p.color;
            ctx.moveTo(p.x + p.tilt + p.r, p.y);
            ctx.lineTo(p.x + p.tilt, p.y + p.tilt + p.r);
            ctx.stroke();

            p.tiltAngle += p.tiltAngleIncremental;
            p.y += (Math.cos(p.d) + 3 + p.r / 2) / 2;
            p.x += Math.sin(p.d);
            p.tilt = Math.sin(p.tiltAngle - p.r / 4) * 15;

            if (p.y > canvas.height) {
              confettiPieces.splice(index, 1);
            }
          });

          if (confettiPieces.length > 0) {
            requestAnimationFrame(draw);
          } else {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
          }
        }

        draw();
      }

      // Selección de premio
      let selectedPrize = null;

      function selectPrize(element, icon, name) {
        // Remover selección previa
        document
          .querySelectorAll(".prize")
          .forEach((p) => p.classList.remove("selected"));

        // Seleccionar nuevo premio
        element.classList.add("selected");
        selectedPrize = { icon, name };

        // Mostrar overlay
        const overlay = document.getElementById("prizeOverlay");
        const background = document.getElementById("prizeBackground");
        //background.textContent = icon;
        overlay.classList.add("active");
      }

      // Base de datos de participantes (código: nombre)
      const participants = {
        1001: "GARCÍA PÉREZ, JUAN CARLOS",
        1002: "RODRÍGUEZ LÓPEZ, MARÍA ELENA",
        1003: "MARTÍNEZ SILVA, JOSÉ ANTONIO",
        1004: "FERNÁNDEZ TORRES, ANA LUCÍA",
        1005: "GONZÁLEZ RAMÍREZ, PEDRO LUIS",
        1006: "SÁNCHEZ MENDOZA, CARMEN ROSA",
        1007: "DÍAZ CASTRO, ROBERTO MANUEL",
        1008: "TORRES VARGAS, SOFÍA ISABEL",
        1009: "FLORES GUTIÉRREZ, LUIS MIGUEL",
        1010: "REYES MORALES, PATRICIA ANDREA",
        2001: "CRUZ NAVARRO, CARLOS EDUARDO",
        2002: "RAMOS ORTIZ, LUCÍA FERNANDA",
        2003: "HERRERA DELGADO, MIGUEL ÁNGEL",
        2004: "MEDINA ROJAS, DIANA MARCELA",
        2005: "JIMÉNEZ SOTO, FRANCISCO JAVIER",
      };

      // Inicializar slots
      function initSlots() {
        for (let i = 1; i <= 4; i++) {
          const slotNumbers = document.querySelector(`#slot${i} .slot-numbers`);
          let numbersHTML = "";
          for (let j = 0; j < 30; j++) {
            numbersHTML += `<div class="slot-number">${Math.floor(
              Math.random() * 10
            )}</div>`;
          }
          slotNumbers.innerHTML = numbersHTML;
        }
      }

      let isSpinning = false;

      function spin() {
        if (isSpinning) return;
        isSpinning = true;

        const button = document.querySelector(".spin-button");
        button.disabled = true;
        button.textContent = "🎰 SORTEANDO... 🎰";
        document.querySelector("#winnerName").textContent = ""

        // Reproducir sonido de giro
        const spinInterval = setInterval(() => {
          playSpinSound();
        }, 100);

        // Obtener códigos disponibles
        const codes = Object.keys(participants);
        const selectedCode = codes[Math.floor(Math.random() * codes.length)];
        const digits = selectedCode.split("");

        // Animar cada slot
        const promises = digits.map((digit, index) => {
          return animateSlot(index + 1, digit);
        });

        Promise.all(promises).then(() => {
          clearInterval(spinInterval);

          // Mostrar ganador
          document.getElementById("winnerName").textContent =
            participants[selectedCode];

          // Reproducir sonido de victoria y confetti
          playWinSound();
          createConfetti();

          isSpinning = false;
          button.disabled = false;
          button.textContent = "🎰 SORTEAR 🎰";
        });
      }

      function animateSlot(slotIndex, finalDigit) {
        return new Promise((resolve) => {
          const slotNumbers = document.querySelector(
            `#slot${slotIndex} .slot-numbers`
          );
          const duration = 2000 + slotIndex * 500; // Cada slot para en diferente momento
          const startTime = Date.now();

          function animate() {
            const elapsed = Date.now() - startTime;
            const progress = Math.min(elapsed / duration, 1);

            // Efecto de desaceleración
            const easing = 1 - Math.pow(1 - progress, 3);
            const position = easing * 3000; // Distancia total de recorrido

            slotNumbers.style.transform = `translateY(-${position}px)`;

            if (progress < 1) {
              requestAnimationFrame(animate);
            } else {
              // Ajustar a la posición final exacta
              const finalPosition = parseInt(finalDigit) * 120;
              slotNumbers.style.transform = `translateY(-${finalPosition}px)`;

              // Regenerar números con el dígito final en la posición correcta
              let newHTML = "";
              for (let i = 0; i < 10; i++) {
                newHTML += `<div class="slot-number">${i}</div>`;
              }
              slotNumbers.innerHTML = newHTML;
              slotNumbers.style.transform = `translateY(-${finalPosition}px)`;

              resolve();
            }
          }

          animate();
        });
      }

      // Inicializar al cargar
      initSlots();
    </script>
  </body>
</html>
