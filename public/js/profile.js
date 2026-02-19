// public/js/profile.js

document.addEventListener('DOMContentLoaded', () => {
  // ─── 1) PROFILE EDIT / SAVE ───────────────────────
  const editBtn    = document.querySelector('.edit-button');
  const cancelBtn  = document.querySelector('.cancel-button');
  const fields     = document.querySelectorAll('.editable');
  const msgBox     = document.getElementById('message-box');
  let isEditing    = false;
  const originals  = {};

  function enableEditing() {
    fields.forEach(el => {
      const key = el.dataset.key;
      originals[key] = el.tagName === 'SELECT' || el.tagName === 'TEXTAREA'
        ? el.value
        : el.textContent;
      if (el.tagName === 'SELECT' || el.tagName === 'TEXTAREA') {
        el.disabled = false;
      } else {
        el.contentEditable = 'true';
      }
      el.classList.add('editing');
    });
    editBtn.textContent    = 'Save';
    cancelBtn.style.display = 'inline-flex';   
    isEditing = true;
  }

  function disableEditing(reset = false) {
    fields.forEach(el => {
      const key = el.dataset.key;
      if (el.tagName === 'SELECT' || el.tagName === 'TEXTAREA') {
        el.disabled = true;
        if (reset) el.value = originals[key];
      } else {
        el.contentEditable = 'false';
        if (reset) el.textContent = originals[key];
      }
      el.classList.remove('editing');
    });
    editBtn.textContent    = 'Edit';
    cancelBtn.style.display = 'none';
    isEditing = false;
  }

  function collectData() {
    const payload = {};
    fields.forEach(el => {
      const key = el.dataset.key;
      payload[key] = (el.tagName === 'SELECT' || el.tagName === 'TEXTAREA')
        ? el.value.trim()
        : el.textContent.trim();
    });
    return payload;
  }

  if (editBtn && cancelBtn && fields.length) {
    editBtn.addEventListener('click', async e => {
      e.preventDefault();
      if (!isEditing) {
        enableEditing();
        return;
      }
      // Save
      const data = collectData();
      msgBox.innerHTML = '';
      try {
        const res = await fetch(window.profileUpdateUrl, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': window.csrfToken,
          },
          body: JSON.stringify(data),
        });
        const result = await res.json();
        const div = document.createElement('div');
        div.className = res.ok ? 'alert alert-success' : 'alert alert-danger';
        div.textContent = res.ok
          ? 'Profile updated successfully.'
          : (result.message || 'Update failed.');
        msgBox.appendChild(div);
        disableEditing(!res.ok);
        if (res.ok) setTimeout(() => location.reload(), 1000);
      } catch (err) {
        const div = document.createElement('div');
        div.className = 'alert alert-danger';
        div.textContent = 'An unexpected error occurred.';
        msgBox.appendChild(div);
        console.error(err);
        disableEditing(true);
      }
    });

    cancelBtn.addEventListener('click', e => {
      e.preventDefault();
      disableEditing(true);
    });
  }

// ─── 2) PROFILE TABS ─────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  const menuLinks = document.querySelectorAll('.profile-menu-link');
  const sections  = document.querySelectorAll('.profile-section');

  // Map from path → tab target
  const routeMap = {
    '/profile-mine':            'details',
    '/profile-mine/followers':  'followers',
    '/profile-mine/following':  'following',
    '/profile-mine/posts':      'posts',
    '/profile-mine/settings':   'settings',
  };

  // Activate a tab by its data-target
  function activateTab(target) {
    menuLinks.forEach(l => l.classList.remove('active'));
    sections.forEach(s => s.classList.remove('active'));

    const link    = document.querySelector(`.profile-menu-link[data-target="${target}"]`);
    const section = document.getElementById(target);

    if (link)    link.classList.add('active');
    if (section) section.classList.add('active');
  }

  // Initialize from the current URL
  const initTab = routeMap[window.location.pathname] || 'details';
  activateTab(initTab);

  // Handle clicks: pushState + activate
  menuLinks.forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      const target = link.dataset.target;
      const href   = link.getAttribute('href');

      // Change URL without reload
      if (href) {
        history.pushState({}, '', href);
      }

      activateTab(target);
    });
  });

  // Handle back/forward
  window.addEventListener('popstate', () => {
    const tab = routeMap[window.location.pathname] || 'details';
    activateTab(tab);
  });
});


  // ─── 3) IMAGE UPLOAD PREVIEWS ──────────────────────
  function initImageUpload({ imgSel, inputSel, formSel, triggerSel }) {
    const img     = document.querySelector(imgSel);
    const input   = document.querySelector(inputSel);
    const form    = document.querySelector(formSel);
    const trigger = triggerSel ? document.querySelector(triggerSel) : null;
    if (!img || !input || !form) return;

    // preview + auto-submit
    input.addEventListener('change', () => {
      const file = input.files[0];
      if (!file) return;
      const reader = new FileReader();
      reader.onload = e => {
        img.src = e.target.result;
        setTimeout(() => form.submit(), 500);
      };
      reader.readAsDataURL(file);
    });

    // clicking the img or trigger opens dialog
    img.addEventListener('click', () => input.click());
    if (trigger) trigger.addEventListener('click', () => input.click());
  }

  // wire up profile‐pic and cover uploads
  initImageUpload({
    imgSel:       '.profile-img',
    inputSel:     '#profilePictureInput',
    formSel:      '#uploadForm',
    triggerSel:   '.camera-icon'
  });
  initImageUpload({
    imgSel:       '.profile-cover',
    inputSel:     '#coverInput',
    formSel:      '#coverUploadForm',
    triggerSel:   '.edit-cover-box'
  });

});


document.addEventListener('DOMContentLoaded', function() {
  const filter = document.getElementById('postFilter');
  const tabs   = ['feed','faculty','community'];

  function showTab(tab) {
    tabs.forEach(name => {
      const panel = document.getElementById(`tab-${name}`);
      if (!panel) return console.warn(`Missing #tab-${name}`);
      panel.classList.toggle('hidden', name !== tab);
    });
  }

  // wire up change event
  filter.addEventListener('change', e => showTab(e.target.value));
  // init
  showTab(filter.value);
});