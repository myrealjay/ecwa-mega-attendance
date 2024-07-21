export function sideBarRoutes() {
    return [
        {
            title: "Dashboard",
            icon: "icon-grid",
            name : "dashboard",
            roles: ['User', 'Super Admin', 'Admin']
        },
        {
            title: "Settings",
            icon: "mdi mdi-settings",
            name : "settings",
            roles: ['Super Admin', 'Admin']
        }
    ];
}