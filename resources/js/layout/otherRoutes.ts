export function otherRoutes() {
    return [
        {
            name : "addQuestions",
            roles: ['Super Admin', 'Admin']
        },
        {
            name : "takeQuiz",
            roles: ['User','Super Admin', 'Admin']
        },
        {
            name : "startQuiz",
            roles: ['User','Super Admin', 'Admin']
        },
        {
            name : "invitations",
            roles: ['Super Admin', 'Admin']
        },
        {
            name : "responses",
            roles: ['Super Admin', 'Admin']
        }
    ];
}