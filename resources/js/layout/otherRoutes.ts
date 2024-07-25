export function otherRoutes() {
    return [
        {
            name: "addQuestions",
            roles: ["Super Admin", "Admin"],
        },
        {
            name: "takeQuiz",
            roles: ["User", "Super Admin", "Admin"],
        },
        {
            name: "startQuiz",
            roles: ["User", "Super Admin", "Admin"],
        },
        {
            name: "add-message",
            roles: ["Super Admin", "Admin"],
        },
        {
            name: "responses",
            roles: ["Super Admin", "Admin"],
        },
    ];
}
