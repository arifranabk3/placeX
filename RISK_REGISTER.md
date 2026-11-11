# PlaceX RISK REGISTER & MITIGATIONS

| Risk ID | Category | Description | Severity | Likelihood | Mitigation Strategy | Status |
|---|---|---|---|---|---|---|
| **RSK-01** | Architecture | Accidental destruction or alteration of approved PlaceX design | Critical | Low | All static HTML and stylesheets kept in root; frontend ports exact HTML markup with identical CSS classes and 1200px max container. | Mitigated |
| **RSK-02** | Security | IDOR and unauthorized listing manipulation | High | Medium | Implemented `ListingPolicy` verifying ownership or administrator status on all mutation actions. | Mitigated |
| **RSK-03** | Privacy | Matrimonial sensitive family and financial data exposure in public search | High | High | `ListingResource` explicitly excludes sensitive matrimonial attributes (`family_details`, `monthly_income`) from public JSON payloads. | Mitigated |
| **RSK-04** | Security | Eavesdropping on private buyer-seller chat channels | High | Medium | Reverb private channels use strict participant verification in `routes/channels.php`. | Mitigated |
| **RSK-05** | Performance | Table lock contention with MyISAM storage engine | High | Low | Explicitly configured `InnoDB` in `backend/config/database.php` and migration schema definitions. | Mitigated |
| **RSK-06** | Platform | Windows AppLocker policy blocking native SWC binary | Medium | High | Next.js fallback configured with Webpack mode (`--webpack`) utilizing Node WebAssembly bindings. | Mitigated |
| **RSK-07** | Operations | MySQL index length limit (1000 bytes on utf8mb4) | Medium | Medium | Set `Schema::defaultStringLength(191)` in `AppServiceProvider` and constrained slug/title lengths. | Mitigated |

