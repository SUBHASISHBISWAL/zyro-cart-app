<?php $base = '../'; ?>
<?php include('../layouts/header.php'); ?>

<style>
.faq-container {
  max-width: 900px;
  margin: 60px auto;
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
  /* theme color */
  font-size: 18px;
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
</style>

<div class="container faq-container">

  <h2 class="text-center mb-4 text-primary font-weight-bold">
    Frequently Asked Questions
  </h2>

  <div class="mb-3">
    <input type="text" class="form-control border-primary" placeholder="Search FAQs...">
  </div>

  <div class="faq-box">
    <div class="faq-question">How to create account?</div>
    <div class="faq-answer">Click on register and fill your details.</div>
  </div>

  <div class="faq-box">
    <div class="faq-question">How to reset password?</div>
    <div class="faq-answer">Click on forgot password and follow steps.</div>
  </div>

  <div class="faq-box">
    <div class="faq-question">Order not delivered?</div>
    <div class="faq-answer">Check tracking or contact support.</div>
  </div>

  <div class="faq-box">
    <div class="faq-question">Refund policy?</div>
    <div class="faq-answer">Refund is processed within 5-7 days.</div>
  </div>

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