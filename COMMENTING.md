# Commenting Guidelines

> Code should explain **how**.
>
> Comments should explain **why**.

If a piece of code needs a long explanation, consider extracting it into a well-named method instead.

---

## Single Line Comment

Use for short explanations that cannot be expressed by code alone.

```php
// Decrease borrowed stock after successful return.
$barang->decrement('jumlah_dipinjam', $jumlah);
```

Good:

```php
// Prevent deleting the last administrator account.
```

Bad:

```php
// Increment total.
$barang->increment('jumlah_total');
```

The code already says that.

---

## PHPDoc (`/** */`)

Use PHPDoc for classes, methods, and properties.

```php
/**
 * Process partial item returns.
 *
 * This method will:
 * - Update stock.
 * - Create stock mutation.
 * - Update loan status.
 *
 * @throws InvalidArgumentException
 */
public function returnItems(...)
```

Also used for:

```php
/**
 * @property string $nama_barang
 * @property int $jumlah_total
 */
```

and

```php
/**
 * @param int $barangId
 * @param int $jumlah
 * @return InvMutasi
 */
```

---

## TODO

Something that should be implemented later.

```php
// TODO: Add authorization check.
// TODO: Move this process to a queue.
```

---

## FIXME

Known bug.

```php
// FIXME: Incorrect stock calculation when transaction is rolled back.
```

---

## NOTE

Important information for future developers.

```php
// NOTE: jumlah_tersedia is computed by an accessor.
```

```php
// NOTE: This endpoint is only used by the admin panel.
```

---

## HACK

Temporary workaround.

```php
// HACK: Manual query used because Eloquent cannot express this relation.
```

Use sparingly.

---

## WARNING

Something dangerous.

```php
// WARNING:
// Deleting this mutation will affect inventory history.
```

---

# General Rules

## ✅ Explain WHY, not WHAT

Good

```php
// Keep inventory history immutable for auditing.
```

Bad

```php
// Loop through items.
foreach (...)
```

---

## ✅ Keep comments up to date

Outdated comments are worse than no comments.

---

## ✅ Prefer good names over comments

Instead of

```php
// Validate loan request
...
```

Prefer

```php
$this->validateLoanRequest();
```

A good method name is the best documentation.

---

## ✅ Don't comment obvious code

Bad

```php
// Return response
return response()->json(...);
```

---

## When should I write a comment?

Ask yourself:

> **Can I understand this code in six months?**

If the answer is **no**, write a comment explaining **why**.

If the answer is **yes**, don't.