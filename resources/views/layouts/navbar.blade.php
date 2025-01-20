<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">CheckList Microservice</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">

                <li class="nav-item">
                    <router-link class="nav-link" to="/">Мои Чек-Листы</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/create">Создать</router-link>
                </li>

                <li class="nav-item">
                    <router-link class="nav-link" to="/admin">Админка</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/telegramLogin">Логин</router-link>
                </li>
            </ul>
        </div>
    </div>
</nav>
