export function endpoints() {
    return {
        login : "/auth/login",
        register: "/auth/register",
        refreshToken: "/auth/refresh",
        logout: "/auth/logout",
        AddCategory: '/category',
        GetCategory: '/category/all',
        fetchCategories: '/category',
        addQuiz: '/quiz',
        getQuiz: '/quiz',
        addQuestions: '/questions',
        getQuestions: '/questions',
        uploadQuestions: '/questions/upload',
        startQuiz: '/quiz/take',
        respond: '/quiz/respond',
        invite:'/quiz/invitation',
        myinvites: '/quiz/my-invitations',
        downloadTemplate: '/questions/download',
        responses: '/responses',
        deleteQuestions: '/questions/delete',
        sendResetLink:'/auth/resetlink',
        resetPassword:'/auth/reset-password',
        ageRestrictions:'/auth/age-restriction',
        reset:'/quiz/invitation/reset'
    }
}