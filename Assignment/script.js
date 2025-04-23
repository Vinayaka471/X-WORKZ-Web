// Like & Dislike Button Toggle
const likeBtn = document.querySelector('.video-actions button:nth-child(1)');
const dislikeBtn = document.querySelector('.video-actions button:nth-child(2)');
let liked = false;
let disliked = false;

likeBtn.addEventListener('click', () => {
  liked = !liked;
  disliked = false;
  updateActions();
});

dislikeBtn.addEventListener('click', () => {
  disliked = !disliked;
  liked = false;
  updateActions();
});

function updateActions() {
  likeBtn.style.backgroundColor = liked ? '#3ea6ff' : '#272727';
  dislikeBtn.style.backgroundColor = disliked ? '#3ea6ff' : '#272727';
}

// Subscribe Button Toggle
const subscribeBtn = document.querySelector('.subscribe-btn');
let subscribed = false;

subscribeBtn.addEventListener('click', () => {
  subscribed = !subscribed;
  subscribeBtn.textContent = subscribed ? 'Subscribed' : 'Subscribe';
  subscribeBtn.style.backgroundColor = subscribed ? 'gray' : 'red';
});