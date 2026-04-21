          <?php if(!empty($user_id)) echo '</div>' ?>
          <?php if(!empty($user_id)) include FOOTER; ?>
        </section>
      </main>
    </section>
    <script>window.BASE_URL = '<?= BASE_URL ?>'</script>
    <?php if(($page ?? null) === "Settings" || ($page ?? null) === "Quality Assurance" || ($page ?? null) === "User Management" || ($page ?? null) === "Analytics"): ?>
      <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <?php endif; ?>
    <?php if(($page ?? null) === "Analytics"): ?>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php endif; ?>
    <?php if(($page ?? null) === ""): ?>
      <script src="<?= LOGIN_JS ?>"></script>
    <?php elseif(($page ?? null) === "Forgot Password"): ?>
      <script src="<?= FORGOT_PASSWORD_JS ?>"></script>
    <?php endif; ?>
  </body>
</html>
