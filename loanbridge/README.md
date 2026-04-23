# LoanBridge — Frontend (HTML/CSS/JS)

Light dashboard + dark sidebar · hybrid aesthetic inspired by Fraunces-serif editorial UIs.

## Files & how they map to your PHP backend

| Frontend file | Replaces / pairs with |
|---|---|
| `index.html` | Public landing + auth (forms POST to `login.php`, `auth.php`) |
| `client_dashboard.html` | `client_dashboard.php` |
| `apply_loan.html` | `apply_loan.php` → posts to `insert_loan.php` |
| `my_loans.html` | `loans.php` (client-scoped) |
| `client_repayments.html` | `repayments.php` (client-scoped) |
| `admin_dashboard.html` | `admin_dashboard.php` |
| `loans.html` | `loans.php` |
| `applications.html` | `applications.php` |
| `repayments.html` | `repayments.php` |
| `overdue.html` | `overdue.php` |
| `analysis.html` | `analysis.php` |
| `add_loan.html` | `add_loan.php` |
| `css/style.css` | design system (replaces `backend/css/*`) |
| `js/app.js` | tab switching, filter chips, Aadhaar formatter, EMI calc |

## Integrating into PHP

1. Drop these files into your `backend/` folder (or a `public/` folder).
2. Rename each `.html` to `.php` and `include 'header.php';` / `include 'navbar.php';` as you wish — or keep the sidebar inline as it is.
3. Replace the static table rows with PHP loops:
   ```php
   <?php while($row = mysqli_fetch_assoc($result)): ?>
     <tr data-status="<?= $row['status'] ?>">
       <td><?= htmlspecialchars($row['borrower']) ?></td>
       ...
     </tr>
   <?php endwhile; ?>
   ```
4. Form `action=""` attributes already point to the correct PHP endpoints.
5. All POST field `name` attributes use common conventions (aadhaar, password, amount, tenure, rate, purpose, etc.) — adjust to match your exact DB columns.

## Design tokens
All colors, fonts, spacing live in `css/style.css` under `:root`. Change `--bg`, `--sidebar`, or pastel tokens (`--peach`, `--mint`, `--lilac`, `--sky`, `--butter`, `--rose`) to re-skin the whole site.

Fonts: Fraunces (display/serif) + Inter (body) + JetBrains Mono — loaded from Google Fonts.
