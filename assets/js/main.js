const PRODUCTS = [
  {
    id: 1,
    name: "Serum Vitamin C Eclat",
    category: "soin-visage",
    categoryLabel: "Soin visage",
    price: 24.9,
    oldPrice: 29.9,
    rating: 4.8,
    reviews: 126,
    badge: "Nouveau",
    image:
      "https://images.unsplash.com/photo-1625772452859-1c03d5bf1137?auto=format&fit=crop&w=900&q=80",
  },
  {
    id: 2,
    name: "Creme Hydratante Aloe Vera",
    category: "soin-visage",
    categoryLabel: "Soin visage",
    price: 18.5,
    oldPrice: null,
    rating: 4.6,
    reviews: 87,
    badge: "",
    image:
      "https://images.unsplash.com/photo-1571781926291-c477ebfd024b?auto=format&fit=crop&w=900&q=80",
  },
  {
    id: 3,
    name: "Fond de Teint Naturel SPF20",
    category: "maquillage",
    categoryLabel: "Maquillage",
    price: 21.0,
    oldPrice: 26.0,
    rating: 4.5,
    reviews: 203,
    badge: "Promo",
    image:
      "https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=900&q=80",
  },
  {
    id: 4,
    name: "Mascara Volume Intense",
    category: "maquillage",
    categoryLabel: "Maquillage",
    price: 13.9,
    oldPrice: null,
    rating: 4.7,
    reviews: 164,
    badge: "",
    image:
      "https://images.unsplash.com/photo-1586495777744-4413f21062fa?auto=format&fit=crop&w=900&q=80",
  },
  {
    id: 5,
    name: "Eau Micellaire Douceur",
    category: "nettoyant",
    categoryLabel: "Nettoyant",
    price: 11.9,
    oldPrice: null,
    rating: 4.4,
    reviews: 91,
    badge: "",
    image:
      "https://images.unsplash.com/photo-1600180758890-6b94519a8ba1?auto=format&fit=crop&w=900&q=80",
  },
  {
    id: 6,
    name: "Huile Capillaire Nourrissante",
    category: "capillaire",
    categoryLabel: "Capillaire",
    price: 16.5,
    oldPrice: 19.9,
    rating: 4.6,
    reviews: 73,
    badge: "Promo",
    image:
      "https://images.unsplash.com/photo-1596462502278-27bfdc403348?auto=format&fit=crop&w=900&q=80",
  },
  {
    id: 7,
    name: "Parfum Rose Poudree",
    category: "parfum",
    categoryLabel: "Parfum",
    price: 39.0,
    oldPrice: 45.0,
    rating: 4.9,
    reviews: 52,
    badge: "Nouveau",
    image:
      "https://images.unsplash.com/photo-1541643600914-78b084683601?auto=format&fit=crop&w=900&q=80",
  },
  {
    id: 8,
    name: "Baume Levres Karite",
    category: "soin-visage",
    categoryLabel: "Soin visage",
    price: 7.9,
    oldPrice: null,
    rating: 4.3,
    reviews: 58,
    badge: "",
    image:
      "https://images.unsplash.com/photo-1611080541599-8c6dbde6ed28?auto=format&fit=crop&w=900&q=80",
  },
];

const CURRENCY = new Intl.NumberFormat("fr-FR", {
  style: "currency",
  currency: "EUR",
});

const CART_KEY = "lumio_cart";
const USERS_KEY = "lumio_users";
const SESSION_KEY = "lumio_session";
let renderDelay;
const SHIPPING_PRICE = 0;

function getCart() {
  try {
    const raw = localStorage.getItem(CART_KEY);
    return raw ? JSON.parse(raw) : [];
  } catch {
    return [];
  }
}

function setCart(cartItems) {
  localStorage.setItem(CART_KEY, JSON.stringify(cartItems));
}

function getCartQuantity() {
  return getCart().reduce((total, item) => total + (item.quantity || 0), 0);
}

function updateCartCount() {
  const cartCount = document.getElementById("cart-count");
  if (!cartCount) return;

  cartCount.textContent = String(getCartQuantity());
  cartCount.classList.add("bump");
  window.setTimeout(() => cartCount.classList.remove("bump"), 320);
}

function showToast(message) {
  const toast = document.getElementById("toast");
  if (!toast) return;

  toast.textContent = message;
  toast.classList.add("show", "success");
  window.setTimeout(() => {
    toast.classList.remove("show", "success");
  }, 1800);
}

function getProductById(id) {
  return PRODUCTS.find((product) => product.id === id);
}

function getUsers() {
  try {
    const raw = localStorage.getItem(USERS_KEY);
    return raw ? JSON.parse(raw) : [];
  } catch {
    return [];
  }
}

function setUsers(users) {
  localStorage.setItem(USERS_KEY, JSON.stringify(users));
}

function getCartTotal() {
  return getCart().reduce((total, item) => total + item.price * item.quantity, 0);
}

function changeCartItemQuantity(id, delta) {
  const cart = getCart()
    .map((item) => (item.id === id ? { ...item, quantity: item.quantity + delta } : item))
    .filter((item) => item.quantity > 0);
  setCart(cart);
}

function starsFromRating(rating) {
  const rounded = Math.round(rating);
  return "★".repeat(rounded) + "☆".repeat(5 - rounded);
}

function addToCart(product) {
  const cart = getCart();
  const existing = cart.find((item) => item.id === product.id);

  if (existing) {
    existing.quantity += 1;
  } else {
    cart.push({
      id: product.id,
      name: product.name,
      category: product.categoryLabel,
      price: product.price,
      quantity: 1,
      image: product.image,
    });
  }

  setCart(cart);
  updateCartCount();
  renderCartDrawer();
  showToast(`${product.name} ajoute au panier`);
}

function productCardTemplate(product) {
  const badgeClass =
    product.badge.toLowerCase() === "nouveau" ? "badge-new" : "badge-promo";
  const oldPriceHtml = product.oldPrice
    ? `<span class="product-price-original">${CURRENCY.format(product.oldPrice)}</span>`
    : "";

  return `
    <article class="product-card" data-id="${product.id}">
      <a href="produit.php?id=${product.id}" class="product-card-img-wrapper" aria-label="Voir ${product.name}">
        ${product.badge ? `<span class="product-badge ${badgeClass}">${product.badge}</span>` : ""}
        <img src="${product.image}" alt="${product.name}" class="product-card-img" loading="lazy" />
      </a>
      <div class="product-card-body">
        <p class="product-category">${product.categoryLabel}</p>
        <a href="produit.php?id=${product.id}" class="product-name">${product.name}</a>
        <div class="product-rating-mini">
          <span class="stars">${starsFromRating(product.rating)}</span>
          <span class="count">(${product.reviews})</span>
        </div>
      </div>
      <div class="product-card-footer">
        <div>
          <p class="product-price">${CURRENCY.format(product.price)}</p>
          ${oldPriceHtml}
        </div>
        <button class="btn-add-card" data-add-id="${product.id}" aria-label="Ajouter ${product.name} au panier">Ajouter</button>
      </div>
    </article>
  `;
}

function initMobileMenu() {
  const burger = document.getElementById("burger-btn");
  const mobileNav = document.getElementById("nav-mobile");
  if (!burger || !mobileNav) return;

  burger.addEventListener("click", () => {
    burger.classList.toggle("open");
    mobileNav.classList.toggle("open");
  });
}

function cartItemTemplate(item) {
  return `
    <article class="drawer-item">
      <img src="${item.image}" alt="${item.name}" class="drawer-item-img" />
      <div class="drawer-item-body">
        <p class="drawer-item-name">${item.name}</p>
        <p class="drawer-item-meta">${item.category}</p>
        <div class="drawer-item-actions">
          <button type="button" data-qty-id="${item.id}" data-delta="-1" aria-label="Diminuer">-</button>
          <span>${item.quantity}</span>
          <button type="button" data-qty-id="${item.id}" data-delta="1" aria-label="Augmenter">+</button>
          <button type="button" data-remove-id="${item.id}" class="drawer-remove">Retirer</button>
        </div>
      </div>
      <p class="drawer-item-price">${CURRENCY.format(item.price * item.quantity)}</p>
    </article>
  `;
}

function renderCartDrawer() {
  const listEl = document.getElementById("cart-drawer-items");
  const totalEl = document.getElementById("cart-drawer-total");
  if (!listEl || !totalEl) return;

  const cart = getCart();
  if (cart.length === 0) {
    listEl.innerHTML = `<p class="drawer-empty">Votre panier est vide.</p>`;
  } else {
    listEl.innerHTML = cart.map(cartItemTemplate).join("");
  }
  totalEl.textContent = CURRENCY.format(getCartTotal());
}

function initCartDrawer() {
  const toggle = document.getElementById("cart-toggle");
  const drawer = document.getElementById("cart-drawer");
  const close = document.getElementById("drawer-close");
  const overlay = document.getElementById("drawer-overlay");
  const listEl = document.getElementById("cart-drawer-items");
  if (!toggle || !drawer || !close || !overlay || !listEl) return;

  function openDrawer() {
    renderCartDrawer();
    overlay.hidden = false;
    drawer.classList.add("open");
    document.body.classList.add("drawer-open");
    drawer.setAttribute("aria-hidden", "false");
  }

  function closeDrawer() {
    drawer.classList.remove("open");
    document.body.classList.remove("drawer-open");
    drawer.setAttribute("aria-hidden", "true");
    window.setTimeout(() => {
      overlay.hidden = true;
    }, 220);
  }

  toggle.addEventListener("click", (event) => {
    event.preventDefault();
    openDrawer();
  });

  close.addEventListener("click", closeDrawer);
  overlay.addEventListener("click", closeDrawer);
  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") closeDrawer();
  });

  listEl.addEventListener("click", (event) => {
    const target = event.target;
    if (!(target instanceof HTMLElement)) return;

    const removeBtn = target.closest("[data-remove-id]");
    if (removeBtn) {
      changeCartItemQuantity(Number(removeBtn.getAttribute("data-remove-id")), -999);
      updateCartCount();
      renderCartDrawer();
      return;
    }

    const qtyBtn = target.closest("[data-qty-id]");
    if (!qtyBtn) return;
    const id = Number(qtyBtn.getAttribute("data-qty-id"));
    const delta = Number(qtyBtn.getAttribute("data-delta"));
    if (!id || !delta) return;

    changeCartItemQuantity(id, delta);
    updateCartCount();
    renderCartDrawer();
  });
}

function initShopPage() {
  const productGrid = document.getElementById("product-grid");
  const filterTabs = document.getElementById("filter-tabs");
  const searchInput = document.getElementById("search-input");
  const noResults = document.getElementById("no-results");
  const resultsCount = document.getElementById("results-count");

  if (!productGrid || !filterTabs || !searchInput || !noResults || !resultsCount) {
    return;
  }

  let activeCategory = "all";
  let query = "";

  function getFilteredProducts() {
    return PRODUCTS.filter((product) => {
      const inCategory = activeCategory === "all" || product.category === activeCategory;
      const inSearch = product.name.toLowerCase().includes(query.toLowerCase());
      return inCategory && inSearch;
    });
  }

  function renderProducts() {
    productGrid.classList.add("is-loading");
    window.clearTimeout(renderDelay);
    renderDelay = window.setTimeout(() => {
      const list = getFilteredProducts();
      productGrid.innerHTML = list.map(productCardTemplate).join("");
      resultsCount.textContent = `${list.length} produit(s) cosmetique(s)`;
      noResults.hidden = list.length > 0;
      productGrid.classList.remove("is-loading");
      productGrid.querySelectorAll(".product-card").forEach((card, index) => {
        card.style.animationDelay = `${Math.min(index * 45, 320)}ms`;
        card.classList.add("card-enter");
      });
    }, 140);
  }

  filterTabs.addEventListener("click", (event) => {
    const target = event.target;
    if (!(target instanceof HTMLButtonElement)) return;

    const nextCategory = target.dataset.category;
    if (!nextCategory) return;

    activeCategory = nextCategory;
    filterTabs.querySelectorAll(".filter-btn").forEach((btn) => btn.classList.remove("active"));
    target.classList.add("active");
    renderProducts();
  });

  searchInput.addEventListener("input", (event) => {
    query = event.target.value.trim();
    renderProducts();
  });

  const resetBtn = document.getElementById("filter-reset");
  if (resetBtn) {
    resetBtn.addEventListener("click", () => {
      query = "";
      activeCategory = "all";
      searchInput.value = "";
      filterTabs.querySelectorAll(".filter-btn").forEach((btn) => btn.classList.remove("active"));
      const allBtn = filterTabs.querySelector('[data-category="all"]');
      if (allBtn) allBtn.classList.add("active");
      renderProducts();
    });
  }

  productGrid.addEventListener("click", (event) => {
    const target = event.target;
    if (!(target instanceof HTMLElement)) return;

    const addBtn = target.closest("[data-add-id]");
    if (!addBtn) return;

    const id = Number(addBtn.getAttribute("data-add-id"));
    const product = PRODUCTS.find((item) => item.id === id);
    if (!product) return;

    addToCart(product);
  });

  renderProducts();
}

function cartRowTemplate(item) {
  return `
    <article class="cart-item" data-cart-id="${item.id}">
      <img src="${item.image}" alt="${item.name}" class="cart-item-img" />
      <div class="cart-item-info">
        <p class="cart-item-name">${item.name}</p>
        <p class="cart-item-cat">${item.category}</p>
        <div class="cart-item-controls">
          <div class="qty-control">
            <button class="qty-btn" data-cart-qty="${item.id}" data-delta="-1" aria-label="Diminuer">−</button>
            <input type="number" class="qty-input" value="${item.quantity}" min="1" readonly />
            <button class="qty-btn" data-cart-qty="${item.id}" data-delta="1" aria-label="Augmenter">+</button>
          </div>
          <button class="cart-item-remove" data-cart-remove="${item.id}">Retirer</button>
        </div>
      </div>
      <p class="cart-item-price">${CURRENCY.format(item.price * item.quantity)}</p>
    </article>
  `;
}

function initCartPage() {
  const itemsList = document.getElementById("cart-items-list");
  const emptyState = document.getElementById("cart-empty");
  const itemCount = document.getElementById("cart-item-count");
  const subtotalEl = document.getElementById("summary-subtotal");
  const shippingEl = document.getElementById("summary-shipping");
  const totalEl = document.getElementById("summary-total");
  const checkoutBtn = document.getElementById("btn-checkout");

  if (!itemsList || !emptyState || !itemCount || !subtotalEl || !shippingEl || !totalEl) {
    return;
  }

  function renderCartPage() {
    const cart = getCart();
    const quantity = getCartQuantity();
    const subtotal = getCartTotal();
    const total = subtotal + SHIPPING_PRICE;

    itemCount.textContent = `${quantity} article${quantity > 1 ? "s" : ""}`;
    subtotalEl.textContent = CURRENCY.format(subtotal);
    shippingEl.textContent = SHIPPING_PRICE === 0 ? "Gratuite" : CURRENCY.format(SHIPPING_PRICE);
    totalEl.textContent = CURRENCY.format(total);
    emptyState.hidden = cart.length > 0;
    itemsList.innerHTML = cart.map(cartRowTemplate).join("");

    if (checkoutBtn) {
      checkoutBtn.disabled = cart.length === 0;
      checkoutBtn.style.opacity = cart.length === 0 ? "0.6" : "1";
    }
  }

  itemsList.addEventListener("click", (event) => {
    const target = event.target;
    if (!(target instanceof HTMLElement)) return;

    const removeBtn = target.closest("[data-cart-remove]");
    if (removeBtn) {
      changeCartItemQuantity(Number(removeBtn.getAttribute("data-cart-remove")), -999);
      updateCartCount();
      renderCartDrawer();
      renderCartPage();
      return;
    }

    const qtyBtn = target.closest("[data-cart-qty]");
    if (!qtyBtn) return;
    const id = Number(qtyBtn.getAttribute("data-cart-qty"));
    const delta = Number(qtyBtn.getAttribute("data-delta"));
    if (!id || !delta) return;

    changeCartItemQuantity(id, delta);
    updateCartCount();
    renderCartDrawer();
    renderCartPage();
  });

  renderCartPage();
}

function initProductPage() {
  const nameEl = document.getElementById("product-name");
  const imageEl = document.getElementById("product-img-main");
  if (!nameEl || !imageEl) return;

  const params = new URLSearchParams(window.location.search);
  const id = Number(params.get("id")) || 1;
  const product = getProductById(id) || PRODUCTS[0];
  const addBtn = document.getElementById("btn-add-cart");
  const categoryEl = document.getElementById("product-category");
  const priceEl = document.getElementById("product-price");
  const oldPriceEl = document.getElementById("product-price-old");
  const descEl = document.getElementById("product-description");
  const breadcrumbName = document.getElementById("breadcrumb-name");
  const breadcrumbCategory = document.getElementById("breadcrumb-category");
  const ratingStars = document.getElementById("product-stars");
  const ratingCount = document.getElementById("product-rating-count");

  nameEl.textContent = product.name;
  imageEl.src = product.image;
  imageEl.alt = product.name;
  if (categoryEl) categoryEl.textContent = product.categoryLabel;
  if (priceEl) priceEl.textContent = CURRENCY.format(product.price);
  if (oldPriceEl) oldPriceEl.textContent = product.oldPrice ? CURRENCY.format(product.oldPrice) : "";
  if (descEl) descEl.textContent = "Une formule premium pensée pour une routine efficace et sensorielle.";
  if (breadcrumbName) breadcrumbName.textContent = product.name;
  if (breadcrumbCategory) breadcrumbCategory.textContent = product.categoryLabel;
  if (ratingStars) ratingStars.textContent = starsFromRating(product.rating);
  if (ratingCount) ratingCount.textContent = `(${product.reviews} avis)`;

  if (addBtn) {
    addBtn.addEventListener("click", () => addToCart(product));
  }
}

function setFieldError(inputId, errorId, message) {
  const input = document.getElementById(inputId);
  const error = document.getElementById(errorId);
  if (!input || !error) return;
  error.textContent = message || "";
  input.classList.toggle("error", Boolean(message));
}

function isValidEmail(value) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
}

function getPasswordStrength(value) {
  let score = 0;
  if (value.length >= 8) score += 1;
  if (/[A-Z]/.test(value)) score += 1;
  if (/[0-9]/.test(value)) score += 1;
  if (/[^A-Za-z0-9]/.test(value)) score += 1;
  return score;
}

function updatePasswordStrength(password) {
  const bar = document.getElementById("strength-bar");
  const label = document.getElementById("strength-label");
  if (!bar || !label) return;

  const strength = getPasswordStrength(password);
  const widths = ["0%", "25%", "50%", "75%", "100%"];
  const colors = ["#d9d1c7", "#c96a5a", "#b58d45", "#7e9487", "#5f7a68"];
  const texts = ["", "Faible", "Moyen", "Bon", "Excellent"];

  bar.style.width = widths[strength];
  bar.style.background = colors[strength];
  label.textContent = texts[strength];
}

function initAuthPage() {
  const loginTab = document.getElementById("tab-login");
  const registerTab = document.getElementById("tab-register");
  const loginPanel = document.getElementById("panel-login");
  const registerPanel = document.getElementById("panel-register");
  if (!loginTab || !registerTab || !loginPanel || !registerPanel) return;

  function switchTab(type) {
    const isLogin = type === "login";
    loginTab.classList.toggle("active", isLogin);
    registerTab.classList.toggle("active", !isLogin);
    loginTab.setAttribute("aria-selected", String(isLogin));
    registerTab.setAttribute("aria-selected", String(!isLogin));
    loginPanel.hidden = !isLogin;
    registerPanel.hidden = isLogin;
  }

  loginTab.addEventListener("click", () => switchTab("login"));
  registerTab.addEventListener("click", () => switchTab("register"));

  const toggleLoginPwd = document.getElementById("toggle-login-pwd");
  const toggleRegPwd = document.getElementById("toggle-reg-pwd");
  const loginPwd = document.getElementById("login-password");
  const regPwd = document.getElementById("reg-password");
  if (toggleLoginPwd && loginPwd) {
    toggleLoginPwd.addEventListener("click", () => {
      loginPwd.type = loginPwd.type === "password" ? "text" : "password";
    });
  }
  if (toggleRegPwd && regPwd) {
    toggleRegPwd.addEventListener("click", () => {
      regPwd.type = regPwd.type === "password" ? "text" : "password";
    });
    regPwd.addEventListener("input", () => updatePasswordStrength(regPwd.value.trim()));
  }

  const btnRegister = document.getElementById("btn-register");
  const btnLogin = document.getElementById("btn-login");
  const regEmail = document.getElementById("reg-email");
  const loginEmail = document.getElementById("login-email");

  if (btnRegister && regPwd && regEmail) {
    btnRegister.addEventListener("click", () => {
      const firstName = document.getElementById("reg-firstname")?.value.trim() || "";
      const lastName = document.getElementById("reg-lastname")?.value.trim() || "";
      const email = regEmail.value.trim().toLowerCase();
      const password = regPwd.value.trim();
      const termsChecked = Boolean(document.getElementById("terms")?.checked);

      setFieldError("reg-firstname", "reg-firstname-err", firstName ? "" : "Prénom requis.");
      setFieldError("reg-lastname", "reg-lastname-err", lastName ? "" : "Nom requis.");
      setFieldError("reg-email", "reg-email-err", isValidEmail(email) ? "" : "Email invalide.");
      setFieldError(
        "reg-password",
        "reg-pwd-err",
        password.length >= 8 ? "" : "8 caractères minimum."
      );
      const termsError = document.getElementById("terms-err");
      if (termsError) termsError.textContent = termsChecked ? "" : "Veuillez accepter les conditions.";

      if (!firstName || !lastName || !isValidEmail(email) || password.length < 8 || !termsChecked) {
        return;
      }

      const users = getUsers();
      const exists = users.some((user) => user.email === email);
      if (exists) {
        setFieldError("reg-email", "reg-email-err", "Cet email existe déjà.");
        return;
      }

      users.push({
        id: Date.now(),
        firstName,
        lastName,
        email,
        password,
      });
      setUsers(users);

      showToast("Inscription reussie. Connectez-vous.");
      switchTab("login");
      if (loginEmail) loginEmail.value = email;
    });
  }

  if (btnLogin && loginPwd && loginEmail) {
    btnLogin.addEventListener("click", () => {
      const email = loginEmail.value.trim().toLowerCase();
      const password = loginPwd.value.trim();

      setFieldError("login-email", "login-email-err", isValidEmail(email) ? "" : "Email invalide.");
      setFieldError("login-password", "login-pwd-err", password ? "" : "Mot de passe requis.");
      if (!isValidEmail(email) || !password) return;

      const users = getUsers();
      const matched = users.find((user) => user.email === email && user.password === password);
      if (!matched) {
        setFieldError("login-password", "login-pwd-err", "Identifiants incorrects.");
        return;
      }

      localStorage.setItem(
        SESSION_KEY,
        JSON.stringify({ id: matched.id, name: matched.firstName, email: matched.email })
      );
      showToast(`Bienvenue ${matched.firstName}`);
      window.setTimeout(() => {
        window.location.href = "index.php";
      }, 650);
    });
  }
}

function initAuthBackground() {
  const imageEl = document.getElementById("auth-bg-image");
  const videoEl = document.getElementById("auth-bg-video");
  const prevBtn = document.getElementById("bg-prev");
  const nextBtn = document.getElementById("bg-next");
  const modeBtn = document.getElementById("bg-toggle-mode");
  if (!imageEl || !videoEl || !prevBtn || !nextBtn || !modeBtn) return;

  const photos = [
    "https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=1800&q=80",
    "https://images.unsplash.com/photo-1571781926291-c477ebfd024b?auto=format&fit=crop&w=1800&q=80",
    "https://images.unsplash.com/photo-1596462502278-27bfdc403348?auto=format&fit=crop&w=1800&q=80",
    "https://images.unsplash.com/photo-1611080541599-8c6dbde6ed28?auto=format&fit=crop&w=1800&q=80",
  ];

  // Add your local/remote MP4 url here if needed.
  const videoSrc = "";

  let index = 0;
  let photoMode = true;
  let slideInterval;

  function applyPhoto(nextIndex) {
    index = (nextIndex + photos.length) % photos.length;
    imageEl.classList.add("fade-out");
    window.setTimeout(() => {
      imageEl.src = photos[index];
      imageEl.classList.remove("fade-out");
    }, 180);
  }

  function startSlideshow() {
    window.clearInterval(slideInterval);
    slideInterval = window.setInterval(() => applyPhoto(index + 1), 5000);
  }

  function setMode(usePhoto) {
    photoMode = usePhoto;
    if (photoMode) {
      videoEl.pause();
      videoEl.classList.remove("active");
      imageEl.style.display = "block";
      modeBtn.textContent = "Photo";
      startSlideshow();
      return;
    }

    if (!videoSrc) {
      showToast("Ajoute un lien MP4 dans main.js pour activer la video.");
      modeBtn.textContent = "Photo";
      photoMode = true;
      startSlideshow();
      return;
    }

    window.clearInterval(slideInterval);
    imageEl.style.display = "none";
    videoEl.src = videoSrc;
    videoEl.classList.add("active");
    videoEl.play().catch(() => {
      showToast("Impossible de lire la video.");
    });
    modeBtn.textContent = "Video";
  }

  prevBtn.addEventListener("click", () => {
    if (!photoMode) return;
    applyPhoto(index - 1);
    startSlideshow();
  });
  nextBtn.addEventListener("click", () => {
    if (!photoMode) return;
    applyPhoto(index + 1);
    startSlideshow();
  });
  modeBtn.addEventListener("click", () => setMode(!photoMode));

  applyPhoto(0);
  startSlideshow();
}

document.addEventListener("DOMContentLoaded", () => {
  updateCartCount();
  initMobileMenu();
  initCartDrawer();
  initShopPage();
  initCartPage();
  initProductPage();
  initAuthPage();
  initAuthBackground();
});
