using CloudinaryDotNet;
using CloudinaryDotNet.Actions;
using criselitocomic_backend.Entities;

namespace criselitocomic_backend.Repositories
{
    public class ComicsRepository
    {
        private static readonly List<Comic> Comics = new();
        private readonly Cloudinary _cloudinary;

        public ComicsRepository(CloudinarySettings cloudinarySettings)
        {
            var myAccount = new Account
            {
                ApiKey = "419917455484235",
                ApiSecret = "xxc1Kg8jy3MXbwQrSsOPVw_Hz48",
                Cloud = "criselitocomic-cloudinary"
            };
            _cloudinary = new(myAccount);
        }

        public void Insert(Comic newComic)
        {
            newComic.Id = Comics.Count.ToString();
            Comics.Add(newComic);
        }

        public List<Comic> GetAll()
        {
            return Comics;
        }

        public Comic GetById(string id)
        {
            return Comics.FirstOrDefault(comic => comic.Id!.Equals(id))!;
        }

        public void Update(string id, Comic comic)
        {
            Comic foundComic = Comics.FirstOrDefault(comic => comic.Id!.Equals(id))!;
            if (foundComic == null)
                return;
            foundComic.Name = comic.Name;
            foundComic.Description = comic.Description;
            foundComic.FilePath = comic.FilePath;
        }

        public void Delete(string id)
        {
            Comics.Remove(GetById(id));
        }

        public string UploadFile(IFormFile file)
        {
            string newFileName = Guid.NewGuid().ToString() + "." + file.FileName.Split('.')[1];
            string newFilePath = Path.Combine(
                        Directory.GetCurrentDirectory(),
                        "temp_criselitocomic_files/" + newFileName
                    );
            using (var fileStream = new FileStream(newFilePath, FileMode.Create))
            {
                file.CopyTo(fileStream);
            }
            RawUploadParams uploadParams = new()
            {
                File = new FileDescription(newFilePath),
            };
            RawUploadResult uploadResult = _cloudinary.Upload(uploadParams);
            return uploadResult.SecureUrl.AbsoluteUri;
        }
    }
}
