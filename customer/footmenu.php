<style>
  /* ツールチップ共通 */
  .tooltip {
    position: relative;
    cursor: pointer;
  }

  .tooltip::after {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 130%;
    left: 50%;
    transform: translateX(-50%);
    background: #363636;
    color: #fff;
    padding: 6px 10px;
    border-radius: 6px;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: opacity .2s ease-in-out;
    font-size: 0.8rem;
    z-index: 100;
  }

  .tooltip:hover::after {
    opacity: 1;
  }
</style>


<footer class="footer has-background-grey-lighter p-5">
  <div class="columns is-vcentered">

    <div class="column is-narrow">
      <figure class="image is-96x96">
        <a href="customer_home.php"><img src="../image/booknest.png" alt="BookNest ロゴ"></a>
      </figure>
    </div>

    <div class="column">
      <p class="title">ガイドライン</p>
      <ul>
        <li><a href="terms_of_use.php" class="has-text-dark">利用規約</a></li>
        <li><a href="commercial_transactions.php" class="has-text-dark">特定商取引法表示について</a></li>
        <li><a href="about_paymethods.php" class="has-text-dark">お支払方法について</a></li>
        <li><a href="privacy_policy.php" class="has-text-dark">プライバシーポリシー</a></li>
      </ul>
    </div>

    <div class="column is-narrow has-text-right">
      <p class="title">SNS share</p>
      <div class="buttons">

        <!-- Twitter -->
        <a href="#"
           class="button is-light is-rounded tooltip"
           data-tooltip="この機能は現在未実装です">
          <span class="icon"><i class="fab fa-twitter"></i></span>
        </a>

        <!-- Instagram -->
        <a href="#"
           class="button is-light is-rounded tooltip"
           data-tooltip="この機能は現在未実装です">
          <span class="icon"><i class="fab fa-instagram"></i></span>
        </a>

      </div>
    </div>

  </div>
</footer>
