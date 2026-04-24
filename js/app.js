
document.querySelectorAll('[data-tabs]').forEach(group => {
  const btns = group.querySelectorAll('button[data-tab]');
  btns.forEach(b => b.addEventListener('click', () => {
    btns.forEach(x => x.classList.remove('is-active'));
    b.classList.add('is-active');
    const target = b.dataset.tab;
    group.parentElement.querySelectorAll('[data-pane]').forEach(p => {
      p.style.display = (p.dataset.pane === target) ? '' : 'none';
    });
  }));
});

document.querySelectorAll('[data-chips]').forEach(group => {
  const btns = group.querySelectorAll('button');
  btns.forEach(b => b.addEventListener('click', () => {
    btns.forEach(x => x.classList.remove('is-active'));
    b.classList.add('is-active');
    const filter = b.dataset.filter;
    const tableId = group.dataset.target;
    if (!tableId) return;
    const rows = document.querySelectorAll(`#${tableId} tbody tr`);
    rows.forEach(r => {
      r.style.display = (filter === 'all' || r.dataset.status === filter) ? '' : 'none';
    });
  }));
});

document.querySelectorAll('input.aadhaar').forEach(inp => {
  inp.addEventListener('input', e => {
    let v = e.target.value.replace(/\D/g, '').slice(0, 12);
    e.target.value = v.replace(/(\d{4})(?=\d)/g, '$1 ').trim();
  });
});

const amt = document.getElementById('amt');
const ten = document.getElementById('ten');
const rate = document.getElementById('rate');
const emiOut = document.getElementById('emiOut');
const totOut = document.getElementById('totOut');
const intOut = document.getElementById('intOut');
function recalc() {
  if (!amt || !ten || !rate || !emiOut) return;
  const P = +amt.value;
  const N = +ten.value;
  const R = (+rate.value) / 12 / 100;
  const emi = R === 0 ? P / N : (P * R * Math.pow(1+R, N)) / (Math.pow(1+R, N) - 1);
  const total = emi * N;
  const interest = total - P;
  const fmt = n => '₹' + Math.round(n).toLocaleString('en-IN');
  emiOut.textContent = fmt(emi);
  totOut.textContent = fmt(total);
  intOut.textContent = fmt(interest);
  document.getElementById('amtOut') && (document.getElementById('amtOut').textContent = fmt(P));
  document.getElementById('tenOut') && (document.getElementById('tenOut').textContent = N + ' months');
  document.getElementById('rateOut') && (document.getElementById('rateOut').textContent = (+rate.value).toFixed(1) + '% p.a.');
}
[amt, ten, rate].forEach(el => el && el.addEventListener('input', recalc));
recalc();

document.querySelectorAll('[data-year]').forEach(el => el.textContent = new Date().getFullYear());
