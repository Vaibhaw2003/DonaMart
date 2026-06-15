</main><!-- end page-content -->
</div><!-- end main-wrap -->
</div><!-- end admin-layout -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Mobile sidebar
const sidebar  = document.getElementById('sidebar');
const sbToggle = document.getElementById('sbToggle');
if(sbToggle){
  sbToggle.addEventListener('click', () => sidebar.classList.toggle('open'));
  document.addEventListener('click', e => {
    if(sidebar.classList.contains('open') && !sidebar.contains(e.target) && !sbToggle.contains(e.target))
      sidebar.classList.remove('open');
  });
}
// Auto-dismiss alerts
document.querySelectorAll('.dm-alert').forEach(el => {
  setTimeout(() => { el.style.transition='opacity 0.4s'; el.style.opacity='0'; setTimeout(()=>el.remove(),400); }, 4000);
});
</script>
</body>
</html>