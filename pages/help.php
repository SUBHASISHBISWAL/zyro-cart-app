<?php $base = '../'; ?>
<?php include('../layouts/header.php'); ?>

<style>
.help-container {
  max-width: 900px;
  margin: 60px auto;
}

.help-title {
  text-align: center;
  margin-bottom: 30px;
}

.help-title h2 {
  font-weight: 700;
  color: #E15260;
}

.faq-box {
  background: #fff;
  margin-bottom: 15px;
  border-radius: 10px;
  border: 1px solid #eee;
  transition: 0.3s;
}

.faq-box:hover {
  transform: translateY(-3px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.faq-question {
  padding: 15px;
  cursor: pointer;
  position: relative;
  font-weight: 600;
  color: #333;
}

.faq-question::after {
  content: "+";
  position: absolute;
  right: 20px;
  color: #D19C97;
}

.faq-box.active .faq-question::after {
  content: "-";
}

.faq-answer {
  max-height: 0;
  overflow: hidden;
  padding: 0 15px;
  transition: 0.4s;
  color: #666;
}

.faq-box.active .faq-answer {
  max-height: 200px;
  padding: 15px;
}

.support-btn {
  display: block;
  text-align: center;
  margin-top: 25px;
  padding: 12px;
  background: #E15260;
  color: white;
  border-radius: 8px;
  text-decoration: none;
  transition: 0.3s;
}

.support-btn:hover {
  background: #c58b86;
}
</style>

<div class="container help-container">

  <div class="help-title">
    <h2>How can we help you?</h2>
  </div>

  <!-- SEARCH -->
  <div class="mb-3">
    <input type="text" class="form-control border-primary" placeholder="Search your problem...">
  </div>

  <!-- FAQ -->
  <div class="faq-box">
    <div class="faq-question">How to place an order?</div>
    <div class="faq-answer">Go to shop page, select product and click add to cart.</div>
  </div>

  <div class="faq-box">
    <div class="faq-question">How to login?</div>
    <div class="faq-answer">Click on login button on top right and enter your details.</div>
  </div>

  <div class="faq-box">
    <div class="faq-question">Payment not working?</div>
    <div class="faq-answer">Check your card or try another payment method.</div>
  </div>

  <div class="faq-box">
    <div class="faq-question">Where is my order?</div>
    <div class="faq-answer">You can track your order in your account section.</div>
  </div>

  <!-- BUTTON -->
  <a href="<?php echo $base; ?>pages/support.php" class="support-btn">
    Contact Support
  </a>

</div>

<script>
const faqs = document.querySelectorAll(".faq-box");

faqs.forEach(faq => {
  faq.addEventListener("click", () => {
    faq.classList.toggle("active");
  });
});
</script>

<?php include('../layouts/footer.php'); ?>