// document.addEventListener('DOMContentLoaded', () => {
//     if (window.location.pathname.endsWith('/test.php')) {
//       const linksToConfirm = document.querySelectorAll('a.confirm-link');
//       const modal = document.getElementById('confirmModal');
//       const btnYes = document.getElementById('confirmYes');
//       const btnNo = document.getElementById('confirmNo');
  
//       let nextHref = null;
  
//       linksToConfirm.forEach(link => {
//         link.addEventListener('click', function(event) {
//           event.preventDefault();
//           nextHref = this.href;
//           modal.style.display = 'flex';
//         });
//       });
  
//       btnYes.addEventListener('click', () => {
//         modal.style.display = 'none';
//         if (nextHref) {
//           window.location.href = nextHref;
//         }
//       });
  
//       btnNo.addEventListener('click', () => {
//         modal.style.display = 'none';
//         nextHref = null;
//       });
  
//       window.addEventListener('click', (e) => {
//         if (e.target === modal) {
//           modal.style.display = 'none';
//           nextHref = null;
//         }
//       });
//     }
//   });
  