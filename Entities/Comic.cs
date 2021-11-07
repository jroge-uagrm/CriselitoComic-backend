namespace criselitocomic_backend.Entities
{
    public class Comic : BaseEntity
    {
        public string? Name { get; set; }
        public string? Description { get; set; }
        public string? FilePath { get; set; }
    }
}