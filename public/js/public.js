// =====================
// 1. Tab Switching
// =====================
document.addEventListener('DOMContentLoaded', function () {
  const links = document.querySelectorAll('.profile-menu-link');
  const sections = document.querySelectorAll('.profile-section, .tab-content');

  links.forEach(link => {
      link.addEventListener('click', function (e) {
          e.preventDefault();

          // Remove active state from all links and sections
          links.forEach(l => l.classList.remove('active'));
          sections.forEach(s => s.classList.remove('active'));

          // Add active to clicked link and corresponding section
          this.classList.add('active');
          const targetId = this.getAttribute('data-target');
          const targetSection = document.getElementById(targetId);
          if (targetSection) {
              targetSection.classList.add('active');
          }
      });
  });

  // Activate first tab by default
  if (links.length) links[0].click();
});

// =====================
// 2. Follow / Unfollow Hover Effect Only (Page Refresh Enabled)
// =====================
$(document).ready(function () {
  // Hover effect: show "Unfollow" instead of "Following"
  $(document).on('mouseenter', '.btn-follow.btn-following', function () {
      $(this).addClass('btn-danger');
      $(this).find('.following').hide();
      $(this).find('.unfollow').show();
  });

  $(document).on('mouseleave', '.btn-follow.btn-following', function () {
      $(this).removeClass('btn-danger');
      $(this).find('.unfollow').hide();
      $(this).find('.following').show();
  });
});
