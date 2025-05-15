
document.addEventListener("DOMContentLoaded", function() {
  feather.replace();

  // Sidebar toggle
  const menuToggle = document.getElementById('menu-toggle');
  const sidebar = document.getElementById('sidebar');
  if (menuToggle && sidebar) {
    menuToggle.addEventListener('click', () => sidebar.classList.toggle('active'));
  }

  // Mode switching
  const modeButtons = document.querySelectorAll('.mode-button');
  const aiMode = document.getElementById('ai-mode');
  const manualMode = document.getElementById('manual-mode');
  modeButtons.forEach(button => {
    button.addEventListener('click', function () {
      modeButtons.forEach(btn => btn.classList.remove('active'));
      this.classList.add('active');

      const selectedMode = this.getAttribute('data-mode');
      aiMode.style.display = selectedMode === 'ai' ? 'block' : 'none';
      manualMode.style.display = selectedMode === 'manual' ? 'block' : 'none';
    });
  });

  // Roles: Add/remove dynamically
  const addRoleBtn = document.getElementById('add-role-btn');
  const rolesContainer = document.getElementById('roles-container');
  if (addRoleBtn && rolesContainer) {
    addRoleBtn.addEventListener('click', function () {
      const newRoleRow = document.createElement('div');
      newRoleRow.classList.add('role-row');
      newRoleRow.innerHTML = `
        <input type="text" class="form-input role-input" placeholder="Role name">
        <button type="button" class="role-action remove-role"><i data-feather="trash-2"></i></button>
      `;
      rolesContainer.appendChild(newRoleRow);
      feather.replace();
    });

    rolesContainer.addEventListener('click', function (e) {
      if (e.target.closest('.remove-role')) {
        e.target.closest('.role-row').remove();
      }
    });
  }

  // Show preview container
  const generateBtn = document.getElementById('generate-dao-btn');
  const previewContainer = document.getElementById('preview-container');
  if (generateBtn && previewContainer) {
    generateBtn.addEventListener('click', function () {
      previewContainer.classList.add('visible');
      setTimeout(() => {
        previewContainer.scrollIntoView({ behavior: 'smooth' });
      }, 100);
    });
  }

  // Confirmation Modal Logic
  function showDAOConfirmationModal(daoData) {
    document.getElementById('modal-dao-name').textContent = daoData.dao_name || '-';
    document.getElementById('modal-dao-symbol').textContent = daoData.dao_symbol || '-';
    document.getElementById('modal-token-supply').textContent = daoData.token_supply ? `${daoData.token_supply.toLocaleString()} ${daoData.token_symbol}` : '-';
    document.getElementById('modal-governance').textContent = daoData.governance_enabled ? 'Yes' : 'No';
    document.getElementById('modal-quorum').textContent = daoData.vote_quorum ? `${daoData.vote_quorum}%` : '-';
    document.getElementById('modal-threshold').textContent = daoData.vote_threshold ? `${daoData.vote_threshold}%` : '-';

    const rolesContainer = document.getElementById('modal-roles');
    rolesContainer.innerHTML = '';
    if (daoData.roles && daoData.roles.length > 0) {
      daoData.roles.forEach(role => {
        const tag = document.createElement('div');
        tag.className = 'role-tag';
        tag.textContent = role;
        rolesContainer.appendChild(tag);
      });
    } else {
      rolesContainer.textContent = 'No roles defined';
    }

    document.getElementById('dao-confirmation-modal').classList.add('visible');
    feather.replace();
  }

  function hideDAOConfirmationModal() {
    document.getElementById('dao-confirmation-modal').classList.remove('visible');
    const status = document.getElementById('deployment-status');
    status.textContent = '';
    status.className = 'deployment-status';
  }

  // Handle modal close
  const closeButton = document.getElementById('modal-close');
  const cancelButtons = document.querySelectorAll('.modal-cancel');
  if (closeButton) closeButton.addEventListener('click', hideDAOConfirmationModal);
  cancelButtons.forEach(btn => btn.addEventListener('click', hideDAOConfirmationModal));

  // Deploy DAO (submit to PHP)
  async function deployDAO() {
    const deployBtn = document.getElementById('deploy-dao-btn');
    const status = document.getElementById('deployment-status');
    deployBtn.disabled = true;
    status.innerHTML = '<span class="loader"></span> Deploying your DAO to Solana...';
    status.className = 'deployment-status loading';

    const form = document.getElementById('manual-dao-form');
    const formData = new FormData(form);

    // Collect roles
    const roleInputs = form.querySelectorAll('.role-input');
    const roles = Array.from(roleInputs).map(input => input.value).filter(r => r !== '');
    formData.append('roles', JSON.stringify(roles));

    try {
      const response = await fetch('dao_creation.php', {
        method: 'POST',
        body: formData
      });

      const result = await response.text();
      status.textContent = 'Deployment Successful!';
      status.className = 'deployment-status success';

      setTimeout(() => {
        window.location.href = 'manage_dao.php';
      }, 3000);
    } catch (error) {
      status.textContent = `Deployment failed: ${error.message}`;
      status.className = 'deployment-status error';
      deployBtn.disabled = false;
    }
  }

  const deployBtn = document.getElementById('deploy-dao-btn');
  if (deployBtn) {
    deployBtn.addEventListener('click', deployDAO);
  }

  // Manual form submission
  const manualForm = document.getElementById('manual-dao-form');
  if (manualForm) {
    manualForm.addEventListener('submit', function (e) {
      e.preventDefault();
     

      const roles = Array.from(manualForm.querySelectorAll('.role-input'))
        .map(input => input.value)
        .filter(val => val !== '');

      const daoData = {
        dao_name: document.getElementById('dao_name').value,
        dao_symbol: document.getElementById('dao_symbol').value,
        token_name: document.getElementById('token_name').value,
        token_symbol: document.getElementById('token_symbol').value,
        token_supply: parseInt(document.getElementById('token_supply').value) || 0,
        governance_enabled: document.getElementById('governance_enabled').checked,
        vote_quorum: parseInt(document.getElementById('vote_quorum').value) || 0,
        vote_threshold: parseInt(document.getElementById('vote_threshold').value) || 0,
        vote_duration: parseInt(document.getElementById('vote_duration').value) || 0,
        vote_days: document.getElementById('vote_days').value || '',
        roles: roles
      };

      showDAOConfirmationModal(daoData);
    });
  }
});

