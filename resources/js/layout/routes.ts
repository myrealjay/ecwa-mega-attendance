export function sideBarRoutes() {
    return [
        {
            title: "Dashboard",
            icon: "icon-grid",
            name: "dashboard",
            roles: ["User", "Super Admin", "Admin"],
        },
        {
            title: "Members",
            icon: "mdi mdi-account-multiple",
            name: "members",
            roles: ["Super Admin", "Admin"],
        },
        {
            title: "Attendance",
            icon: "mdi mdi-marker-check",
            name: "attendance",
            roles: ["Super Admin", "Admin"],
        },
    ];
}
