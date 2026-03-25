<?php $base = '../'; ?>
<?php include('../layouts/header.php'); ?>

<style>
.support-container {
  max-width: 600px;
  margin: 60px auto;
}

.support-box {
  background: #fff;
  padding: 25px;
  border-radius: 12px;
  border: 1px solid #eee;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.support-title {
  text-align: center;
  margin-bottom: 20px;
}

.support-title h2 {
  color: #E15260;
  font-weight: 700;
}

.support-btn {
  background: #E15260;
  border: none;
  color: #fff;
}

.support-btn:hover {
  background: #c58b86;
}
</style>

<div class="container support-container">

  <div class="support-box">

    <div class="support-title">
      <h2>Contact Support</h2>
    </div>

    <form>

      <div class="form-group">
        <input type="text" class="form-control" placeholder="Your Name" required>
      </div>

      <div class="form-group">
        <input type="email" class="form-control" placeholder="Your Email" required>
      </div>

      <div class="form-group">
        <select class="form-control" required>
          <option>Select Issue</option>
          <option>Login Problem</option>
          <option>Payment Issue</option>
          <option>Bug Report</option>
        </select>
      </div>

      <div class="form-group">
        <textarea class="form-control" rows="4" placeholder="Describe your issue..." required></textarea>
      </div>

      <button type="submit" class="btn btn-block support-btn">
        Submit Request
      </button>

    </form>

  </div>

</div>

<?php include('../layouts/footer.php'); ?>