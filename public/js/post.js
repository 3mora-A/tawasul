// post.js

// ─── TAB SWITCHING ───────────────────────────────────
function showStatusTab() {
  document.getElementById('status').style.display = 'block';
  document.getElementById('choice').style.display = 'none';
}

function showPhotosTab() {
  document.getElementById('status').style.display = 'none';
  document.getElementById('choice').style.display = 'block';
}

function togglePostTab(value) {
  // Hide all tabs
  ['feed', 'faculty'].forEach(tab => {
    document.getElementById(`tab-${tab}`).classList.add('hidden');
  });
  // Show selected
  document.getElementById(`tab-${value}`).classList.remove('hidden');
}

// ─── COMMENTS ────────────────────────────────────────
function showComment(postId) {
  document.getElementById(`comment-expanded-${postId}`).style.display = 'block';
  document.getElementById(`comment-show-${postId}`).style.display = 'none';
}

function cancelComment(postId) {
  document.getElementById(`comment-expanded-${postId}`).style.display = 'none';
  document.getElementById(`comment-show-${postId}`).style.display = 'block';
  document.getElementById(`comment-input-${postId}`).value = '';
}

function submitComment(postId) {
  const input = document.getElementById(`comment-input-${postId}`);
  const content = input.value.trim();
  if (!content) return;

  fetch(`/posts/${postId}/comments`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({ content })
  })
    .then(res => {
      if (!res.ok) throw new Error('Server error');
      return res.json();
    })
    .then(() => location.reload())
    .catch(() => location.reload());
}

document.addEventListener('DOMContentLoaded', () => {
  // Cache CSRF token once
  const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute('content');

  // Attach to all like buttons
  document.querySelectorAll('.like-button').forEach(button => {
    button.addEventListener('click', async () => {
      const postId = button.dataset.postId;
      const isLiked = button.classList.contains('liked');

      try {
        const response = await fetch(`/posts/${postId}/like`, {
          method: isLiked ? 'DELETE' : 'POST',
          headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
          },
        });

        if (!response.ok) {
          throw new Error(`Server returned ${response.status}`);
        }

        const data = await response.json();

        // Update UI
        button.classList.toggle('liked', data.liked);

        const svg = button.querySelector('svg');
        if (svg) {
          svg.setAttribute('fill', data.liked ? 'red' : 'none');
        }

        const countEl = button.querySelector('.like-count');
        if (countEl) {
          countEl.textContent = data.count;
        }
      } catch (err) {
        console.error('Like toggle failed:', err);
      }
    });
  });
});

// ─── MEDIA UPLOAD PREVIEW ────────────────────────────
function initMediaUploadPreview() {
  const uploadInput = document.getElementById('media-upload');
  const previewBox  = document.getElementById('media-preview');
  const uploadText  = document.getElementById('upload-text');

  if (!uploadInput) return;
  uploadInput.addEventListener('change', () => {
    const file = uploadInput.files[0];
    previewBox.innerHTML = '';

    if (!file) {
      previewBox.style.display = 'none';
      uploadText.style.display = 'block';
      return;
    }
    uploadText.style.display = 'none';
    previewBox.style.display = 'block';
    const nameEl = document.createElement('p');
    nameEl.textContent = `Selected file: ${file.name}`;
    previewBox.appendChild(nameEl);
  });
}

// ─── DROPDOWN MENUS ───────────────────────────────────
function toggleMenu(event) {
  event.stopPropagation();
  const btn      = event.currentTarget;
  const wrapper  = btn.closest('.menu-wrapper');
  const dropdown = wrapper.querySelector('.dropdown-menu');

  // Close others
  document.querySelectorAll('.menu-wrapper').forEach(w => {
    const dd = w.querySelector('.dropdown-menu');
    const b  = w.querySelector('.intro-menu-post');
    if (dd && dd !== dropdown) dd.style.display = 'none';
    if (b  && b  !== btn) {
      b.style.backgroundColor = 'transparent';
      b.style.color           = '#888';
    }
  });

  // Toggle this one
  const opening = dropdown.style.display !== 'block';
  dropdown.style.display       = opening ? 'block' : 'none';
  btn.style.backgroundColor    = opening ? 'rgba(255,255,255,0.1)' : 'transparent';
  btn.style.color              = opening ? '#fff' : '#888';
}

// Close menus on outside click
function initMenuClosers() {
  document.addEventListener('click', () => {
    document.querySelectorAll('.menu-wrapper').forEach(w => {
      const dd = w.querySelector('.dropdown-menu');
      const b  = w.querySelector('.intro-menu-post');
      if (dd) dd.style.display = 'none';
      if (b) {
        b.style.backgroundColor = 'transparent';
        b.style.color           = '#888';
      }
    });
  });

  document.querySelectorAll('.intro-menu-post').forEach(btn => {
    btn.addEventListener('click', toggleMenu);
  });
}

// ─── INITIALIZE ALL ──────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  // Default tab
  togglePostTab('feed');

  // Interactive features
  initLikeButtons();
  initMediaUploadPreview();
  initMenuClosers();
});
