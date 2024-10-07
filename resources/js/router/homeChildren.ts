import Dashboard from "../views/Dashboard.vue";

const childRoutes = [
    {
        path: "",
        name: "dashboard",
        component: Dashboard,
    },
    {
        path: "email-templates",
        name: "email-templates",
        component: () => import("../views/EmailTemplate.vue"),
    },
    {
        path: "sms-emplates",
        name: "sms-templates",
        component: () => import("../views/SmsTemplate.vue"),
    },
    {
        path: "members",
        name: "members",
        component: () => import("../views/Members.vue"),
    },
    {
        path: "attendance",
        name: "attendance",
        component: () => import("../views/Attendance.vue"),
    },
    {
        path: "members/:id",
        name: "member",
        component: () => import("../views/MemberDetails.vue"),
        props: true,
    },
    {
        path: "/committee",
        name: "committee",
        component: () => import("../views/FollowUpCommittee.vue")
    },
    {
        path: "admins",
        name: "admins",
        component: () => import("../views/Admins.vue")
    },
    {
        path: "custom-messages",
        name: "custom-messages",
        component: () => import("../views/Emails.vue")
    },
];

export function homeChildren() {
    return childRoutes;
}
