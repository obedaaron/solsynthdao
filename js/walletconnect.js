document.addEventListener('DOMContentLoaded', () => {
    const walletModal = document.getElementById('wallet-modal');
    const connectWalletBtn = document.querySelector('.btn-primary');
    const closeBtn = document.querySelector('.wallet-modal-close');
    const phantomBtn = document.getElementById('connect-phantom');
    const solflareBtn = document.getElementById('connect-solflare');
  
    connectWalletBtn.addEventListener('click', (e) => {
      e.preventDefault();
      walletModal.style.display = 'block';
    });
  
    closeBtn.addEventListener('click', () => {
      walletModal.style.display = 'none';
    });
  
    window.addEventListener('click', (e) => {
      if (e.target === walletModal) {
        walletModal.style.display = 'none';
      }
    });
  
    phantomBtn.addEventListener('click', async () => {
      try {
        await connectPhantom();
        walletModal.style.display = 'none';
      } catch (err) {
        console.error("Error connecting to Phantom:", err);
      }
    });
  
    solflareBtn.addEventListener('click', async () => {
      try {
        await connectSolflare();
        walletModal.style.display = 'none';
      } catch (err) {
        console.error("Error connecting to Solflare:", err);
      }
    });
  });
  
  // Phantom Wallet Connection
  async function connectPhantom() {
    if (window.solana && window.solana.isPhantom) {
      try {
        const resp = await window.solana.connect();
        const walletAddress = resp.publicKey.toString();
        console.log("Connected to Phantom:", walletAddress);
  
        // Send wallet address to backend PHP for login
        const response = await fetch('http://localhost/solsynth/phantom_login.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: new URLSearchParams({
            walletAddress: walletAddress,
          }),
        });
  
        const result = await response.json();
  
        if (result.status === 'success') {
          window.location.href = 'dashboard.php';
        } else {
          console.error('Login failed:', result.error);
          alert('Login failed: ' + result.error);
        }
  
      } catch (err) {
        console.error("Phantom connection rejected:", err);
        throw err;
      }
    } else {
      alert("Phantom wallet not found. Please install it.");
      window.open("https://phantom.app/", "_blank");
    }
  }
  
  // Solflare Wallet Connection (unchanged)
  async function connectSolflare() {
    if (typeof Solflare === "undefined") {
      alert("Solflare not found. Please include the Solflare SDK script.");
      return;
    }
  
    const solflare = new Solflare();
    await solflare.connect();
  
    if (solflare.isConnected) {
      console.log("Connected to Solflare:", solflare.publicKey.toString());
      window.location.href = "dashboard.php";
    } else {
      throw new Error("Solflare connection failed");
    }
  }
  