<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img
                    src="../assets/images/megalogo.jpg"
                    alt="logo"
                    style="width: 70px"
                />
                Ecwa Mega Gbagada
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<style scoped>
    .bg-primary {
        background-color: #aeafb3 !important;
    }

    .navbar {
        font-weight: 400;
        -webkit-box-shadow:0px 5px 21px -5px #252f54;
        -moz-box-shadow: 0px 5px 21px -5px #252f54;
        box-shadow:0px 5px 21px -5px #252f54;
    }
</style>
