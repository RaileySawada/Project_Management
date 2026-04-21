<div id="global-spinner" class="spinner hidden">
  <div class="spinner-content">
    <div class="orbit-system">
      <div class="orbit orbit-1"></div>
      <div class="orbit orbit-2"></div>
      <div class="orbit orbit-3"></div>
      <div class="center-sphere">
        <div class="logo-container">
          <img src="<?= LOGO ?>" alt="School Logo" class="logo">
        </div>
        <div class="glow"></div>
      </div>
    </div>
  </div>
</div>

<style>
.spinner {
  position: fixed !important;
  inset: 0 !important;
  background: #ffffff77 !important;
  backdrop-filter: blur(2px) !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  opacity: 1;
  pointer-events: none !important;
  z-index: 9999999 !important;
  transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1) !important;
}

.spinner.hidden {
  opacity: 0;
  pointer-events: none !important;
}

.spinner.show {
  opacity: 1;
}

.spinner-content {
  position: relative !important;
  perspective: 1000px !important;
}

.orbit-system {
  position: relative !important;
  width: 140px !important;
  height: 140px !important;
  transform-style: preserve-3d !important;
}

.orbit {
  position: absolute !important;
  top: 50% !important;
  left: 50% !important;
  border: 2px solid transparent !important;
  border-radius: 50% !important;
  transform-origin: center !important;
}

.orbit-1 {
  width: 140px !important;
  height: 140px !important;
  background-color: #fff;
  margin: -70px 0 0 -70px !important;
  border-top-color: #1e40af !important;
  border-right-color: #1e40af40 !important;
  animation: orbit-rotate 2s linear infinite !important;
  box-shadow: 0 0 20px #1e40af75 !important;
}

.orbit-2 {
  width: 110px !important;
  height: 110px !important;
  margin: -55px 0 0 -55px !important;
  border-bottom-color: #3b82f6 !important;
  border-left-color: #3b82f640 !important;
  animation: orbit-rotate 1.5s linear infinite reverse !important;
  box-shadow: 0 0 15px #3b82f630 !important;
}

.orbit-3 {
  width: 80px !important;
  height: 80px !important;
  margin: -40px 0 0 -40px !important;
  border-top-color: #60a5fa !important;
  border-bottom-color: #60a5fa40 !important;
  animation: orbit-rotate 1s linear infinite !important;
  box-shadow: 0 0 10px #60a5fa30 !important;
}

.center-sphere {
  position: absolute !important;
  top: 50% !important;
  left: 50% !important;
  width: 70px !important;
  height: 70px !important;
  margin: -35px 0 0 -35px !important;
  border-radius: 50% !important;
  background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
  box-shadow: 
    0 8px 32px rgba(30, 64, 175, 0.15),
    inset 0 2px 8px rgba(255, 255, 255, 0.8),
    inset 0 -2px 8px rgba(0, 0, 0, 0.05) !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  z-index: 10 !important;
  animation: sphere-pulse 2s ease-in-out infinite !important;
}

.logo-container {
  width: 50px !important;
  height: 50px !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  border-radius: 50% !important;
  position: relative !important;
  z-index: 2 !important;
}

.logo {
  margin-top: 4px;
  width: 100% !important;
  height: 100% !important;
  object-fit: contain !important;
}

.glow {
  position: absolute !important;
  inset: -10px !important;
  border-radius: 50% !important;
  background: radial-gradient(circle, #3b82f640 0%, transparent 70%) !important;
  z-index: 1 !important;
}

@keyframes orbit-rotate {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.spinner::before,
.spinner::after {
  content: '' !important;
  position: absolute !important;
  width: 4px !important;
  height: 4px !important;
  background: #3b82f6 !important;
  border-radius: 50% !important;
  opacity: 0 !important;
  animation: particle 3s ease-in-out infinite !important;
}

.spinner::before {
  top: calc(50% - 100px) !important;
  left: calc(50% - 100px) !important;
}

.spinner::after {
  top: calc(50% + 100px) !important;
  left: calc(50% + 100px) !important;
  animation-delay: 1.5s !important;
}

@keyframes particle {
  0%, 100% {
    opacity: 0;
    transform: scale(0);
  }
  50% {
    opacity: 0.6;
    transform: scale(1.5);
  }
}
</style>