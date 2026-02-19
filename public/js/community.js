
function getCommunityId(postId) {
  const wrapper = document.getElementById(`community-post-${postId}`);
  return wrapper?.dataset.communityId || null;
}

function submitComment(postId) {
  const communityId = getCommunityId(postId);
  const input       = document.getElementById(`comment-input-${postId}`);
  const content     = input.value.trim();

  if (!communityId) {
    alert('Unable to find community ID—check data-community-id on the wrapper.');
    return;
  }
  if (!content) {
    alert('Please type a comment before submitting.');
    return;
  }

  fetch(
    `/communities/${communityId}/posts/${postId}/comments`,
    {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept':       'application/json',
        'X-CSRF-TOKEN': document
                           .querySelector('meta[name="csrf-token"]')
                           .content
      },
      body: JSON.stringify({ content }),
    }
  )
  .then(res => {
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    return res.json();
  })
  .then(data => {
    // either reload or append the new comment…
    location.reload();
  })
  .catch(err => {
    console.error('Comment failed:', err);
    alert('Failed to post comment. See console for details.');
  });
}






document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".like-button").forEach(button => {
    button.addEventListener("click", function () {
      const postId      = this.dataset.postId;
      const communityId = this.dataset.communityId;
      const liked       = this.classList.contains("liked");

      if (!communityId) {
        console.error("Missing community ID for like-button on post", postId);
        return;
      }

      fetch(
        `/communities/${communityId}/posts/${postId}/like`,
        {
          method: liked ? "DELETE" : "POST",
          headers: {
            "X-CSRF-TOKEN": document
                               .querySelector('meta[name="csrf-token"]')
                               .getAttribute("content"),
            "Content-Type": "application/json",
            "Accept":       "application/json",
          },
        }
      )
      .then(res => {
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        return res.json();
      })
      .then(data => {
        this.classList.toggle("liked", data.liked);
        this.querySelector("svg")
            .setAttribute("fill", data.liked ? "red" : "none");
        this.querySelector(".like-count")
            .textContent = data.count;
      })
      .catch(err => {
        console.error("Community like failed:", err);
      });
    });
  });
});


