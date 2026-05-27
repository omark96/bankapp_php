<?php
?>

<div class="tab-list">
    <button hx-get="/admin/users" class="tab-list__tab selected">
        Användare
    </button>
    <button hx-get="/admin/accounts" class="tab-list__tab">
        Konton
    </button>
    <button hx-get="/admin/transactions" class="tab-list__tab">
        Transaktioner
    </button>
</div>

<div id="tab-content" class="tab-content">

    <button hx-get="/admin/users/create"
            hx-target="this"
            hx-swap="outerHTML"
    >
        Skapa ny användare
    </button>

    <form hx-post="/admin/users/table"
          hx-trigger="input changed delay:500ms"
          hx-swap="innerHTML"
          hx-target="#userTable"
          hx-include="#table-csrf-form"
          class="filter-form"
          id="usersFilterForm"
    >
        <label for="cardNumber" class="filter-form__label">Från
            <input class="filter-form__input"
                   type="number"
                   name="cardNumber"
                   placeholder="Kortnummer"
                   value="<?= e($filter->cardNumber ?? "") ?>"
            >
        </label>
        <label for="name" class="filter-form__label">Från
            <input class="filter-form__input"
                   type="text"
                   name="name"
                   placeholder="Namn"
                   value="<?= e($filter->name ?? "") ?>"
            >
        </label>
        <label for="role" class="filter-form__label">Roll
            <select name="role">
                <option value="">Alla</option>
                <option value="user">user</option>
                <option value="admin">admin</option>
            </select>
        </label>
    </form>

    <div id="userTable"
         hx-get="/admin/users/table"
         hx-trigger="load"
         hx-target="this"
         hx-swap="innerHTML">
    </div>
</div>
