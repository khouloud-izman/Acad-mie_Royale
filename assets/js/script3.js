function showVideo(index) {
  const video = document.getElementById('video-' + index);
  const btn = video.previousElementSibling.querySelector('.video-btn');

  video.classList.add('active');
  btn.style.display = 'none';
}
